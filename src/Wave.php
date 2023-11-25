<?php

namespace Jeffgreco13\Wave;

use Http;
use Exception;
use Illuminate\Support\Arr;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Jeffgreco13\Wave\Node;
use Jeffgreco13\Wave\GraphQL\Query;
use Jeffgreco13\Wave\GraphQL\Mutation;

class Wave
{
    protected $client;
    protected $url;
    protected $token;
    protected $businessId;
    protected $requestType; // query or mutation
    protected $requestsThatNeedBusinessId = ['customerCreate','productCreate','customers', 'customerExists','products','business','taxes'];
    protected $requestsWithPagination = ['businesses','customers','products'];
    protected $cachedMethod;
    protected $cachedParams;
    protected $cachedQuery;
    protected $cachedVariables;
    protected $cachedResponse;
    protected $pageInfo = [];

    public function __construct(Http $client = null, $graphqlUrl = null, $token = null, $businessId = null)
    {
        $this->token = ($token ? $token : config('laravel-wave.access_token'));
        if (empty($this->token)) {
            throw new Exception("Wave access token is required.", 400);
        }

        $this->url = ($graphqlUrl ? $graphqlUrl : config('laravel-wave.graphql_uri'));
        if (empty($this->url)) {
            throw new Exception("Wave GraphQL URI is required.", 400);
        }

        $this->businessId = ($businessId ? $businessId : config('laravel-wave.business_id'));

        $this->client = $client ?: Http::withToken($this->token)->asJson();
    }

    /**
     * @param $method
     * @param $params
     * @return mixed|string
     *
     * @throws Exception
     */
    public function __call($method, $params)
    {
        $this->cachedMethod = $method;
        $this->cachedParams = $params;

        if ( method_exists(Mutation::class, $this->cachedMethod) ) {
            $this->requestType = "mutation";
            // This is a Mutation
            if (! $this->is_assoc($this->cachedParams[0])) {
                throw new Exception('Variables are expected to be an associative array.', 422);
            }
            $this->cachedQuery = Mutation::$method();
            $this->cachedVariables = $this->cachedParams[0];

            // Set the businessId if required for this mutation and not already set.
            if (in_array($this->cachedMethod, $this->requestsThatNeedBusinessId) && !Arr::has($this->cachedVariables, 'input.businessId')) {
                data_set($this->cachedVariables, 'input.businessId', $this->businessId);
            }
        } else if(method_exists(Query::class, $this->cachedMethod)) {
            // This is a Query.
            $this->requestType = "query";
            $this->cachedQuery = Query::$method();
            $this->cachedVariables = count($this->cachedParams) > 0 ? $this->cachedParams[0] : [];

            // Set the businessId if required for this query and not already set.
            if (in_array($this->cachedMethod, $this->requestsThatNeedBusinessId) && !Arr::has($this->cachedVariables, 'businessId')) {
                data_set($this->cachedVariables, 'businessId', $this->businessId);
            }

            // If this query has pagination, set defaults that we can use later.
            if (in_array($this->cachedMethod,$this->requestsWithPagination)){
                $this->cachedVariables['page'] = data_get($this->cachedVariables,'page',null) ?? 1;
                $this->cachedVariables['pageSize'] = data_get($this->cachedVariables, 'pageSize', null) ?? 10;
            }
        } else {
            throw new Exception('This method does not exist or has not been set up yet.');
        }
        // Make the request
        $response = $this->client->post($this->url, [
            'query' => $this->cachedQuery,
            'variables' => $this->cachedVariables,
        ]);

        // Handle the response
        if ($response->failed()) {
            $errors = collect(data_get($response->json(), 'errors', []));
            $error = $errors->first();
            $code = data_get($error, 'extensions.code', null);
            $message = data_get($error, 'message', null);
            \Log::debug($error);
            switch ($code) {
                case 'GRAPHQL_VALIDATION_FAILED':
                    throw new Exceptions\MalformedQueryException("Malformed GraphQL query: {$message}");
                    break;
                case 'NOT_FOUND':
                    throw new Exceptions\ResourceNotFoundException("Resource not found: {$message}");
                    break;
                case 'UNAUTHENTICATED':
                    throw new Exceptions\AuthenticationException("Authentication failed: {$message}");
                    break;
                case 'INTERNAL_SERVER_ERROR':
                    throw new Exceptions\ExecutionException("Execution error: {$message}");
                    break;
                case 'VARIABLE_VALUE':
                    throw new \Exception("Incorrect values provided: {$message}");
                default:
                    throw new \Exception('Wave GraphQL request failed with an unknown error.');
            }
        }
        $this->cachedResponse = $response->json();
        // Try to extract pageInfo from the request if it exists
        $this->pageInfo = $this->recursiveFindByKey(haystack: $this->cachedResponse,needle:'pageInfo');
        return $this->cachedResponse;
    }

    public function getPageInfo()
    {
        return $this->pageInfo;
    }

    public function paginate()
    {
        if ($this->hasNextPage())
        {
            return $this->getNextPage();
        } else {
            return false;
        }
    }

    public function isLastPage()
    {
        return data_get($this->pageInfo, 'currentPage', 1) == data_get($this->pageInfo, 'totalPages', 1);
    }

    public function hasNextPage()
    {
        return data_get($this->pageInfo,'currentPage',1) < data_get($this->pageInfo, 'totalPages',1);
    }

    public function getNextPage()
    {
        if (!$this->hasNextPage()){
            return null;
        }
        $page = data_get($this->cachedVariables,'page');
        $this->cachedVariables['page'] = ++$page;
        return $this->{$this->cachedMethod}($this->cachedVariables);
    }

    public function getNodes()
    {
        $edges = collect($this->recursiveFindByKey($this->cachedResponse,'edges') ?? []);
        return $edges->pluck('node')->map(function($item){
            return new Node($item);
        });
    }

    public function getBusinessId()
    {
        return $this->businessId;
    }

    private function recursiveFindByKey(array $haystack,$needle)
    {
        $iterator  = new RecursiveArrayIterator($haystack);
        $recursive = new RecursiveIteratorIterator(
            $iterator,
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($recursive as $key => $value) {
            if ($key === $needle) {
                return $value;
            }
        }
        return null;
    }

    private function is_assoc($arr)
    {
        if (! is_array($arr)) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
