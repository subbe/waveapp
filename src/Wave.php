<?php

namespace Jeffgreco13\Wave;

use Exception;
use Http;
use Jeffgreco13\Wave\GraphQL\Mutation;
use Jeffgreco13\Wave\GraphQL\Query;

class Wave
{
    protected $client;
    protected $url;
    protected $token;
    protected $businessId;
    private $responseBuilder;

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
        $query = null;
        $variables = null;

        if ( method_exists(Mutation::class, $method) ) {
            // This is a Mutation
            if (! $this->is_assoc($params[0])) {
                throw new Exception('Variables are expected to be an associative array.', 422);
            }
            $query = Mutation::$method();
            $variables = $params[0];
        } else {
            // Otherwise, try the Query.
            $query = Query::$method();
            $variables = count($params) > 0 ? $params[0] : ['businessId'=>$this->getBusinessId()];
        }
        // Prepare the request
        $request = [
            'query' => $query,
            'variables' => $variables,
        ];

        $response = $this->client->post($this->url, $request);
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
                default:
                    throw new \Exception('Wave GraphQL request failed with an unknown error.');
            }
        }
        return $response->json();
    }

    public function getBusinessId()
    {
        return $this->businessId;
    }

    private function is_assoc($arr)
    {
        if (! is_array($arr)) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
