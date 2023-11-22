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

        $this->responseBuilder = new ResponseBuilder();
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

        try {
            $response = $this->client->post($this->url, $request);
            return $this->responseBuilder->success($response);
        } catch (Exception $e) {
            return $this->responseBuilder->errors($e);
        }
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
