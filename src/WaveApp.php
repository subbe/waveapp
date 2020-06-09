<?php


namespace Subbe\WaveApp;

use Exception;
use GuzzleHttp\Client;
use Subbe\WaveApp\GraphQL\Mutation;
use Subbe\WaveApp\GraphQL\Query;

class WaveApp
{
    private $client;
    private $headers;
    private $url;
    private $token;
    private $businessId;

    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    public function __construct($graphqlUrl = null, $token = null, $businessId = null)
    {
        $this->token = ($token ? $token : config('waveapp.access_token'));
        if (empty($this->token)) {
            throw new Exception("Please provide wave app's token", 400);
        }

        $this->url = ($graphqlUrl ? $graphqlUrl : config('waveapp.graphql_uri'));
        if (empty($this->url)) {
            throw new Exception("Please provide wave app's graphql uri", 400);
        }

        $this->businessId = ($businessId ? $businessId : config('waveapp.business_id'));

        $this->client = new Client();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->token,
        ];
        $this->responseBuilder = new ResponseBuilder();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed|string
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        $query = null;
        $variables = null;
        $operationName = null;

        if (count($arguments) == 2) {
            if (! is_string($arguments[1])) {
                throw new Exception("Operation name is expected to be a string.", 422);
            }
            if (! $this->is_assoc($arguments[0])) {
                throw new Exception("Variables are expected to be an associative array.", 422);
            }
            $query = Mutation::$name();
            $variables = $arguments[0];
            $operationName = $arguments[1];
        } elseif (count($arguments) > 2) {
            throw new Exception('Too many arguments', 422);
        } else {
            $query = Query::$name();
            $variables = count($arguments) > 0 ? $arguments[0] : null;
        }

        $options = [
            'json' => [
                'query' => $query,
                'variables' => $variables,
                'operationName' => $operationName,

            ],
            'headers' => $this->headers
        ];

        try {
            $res = $this->client->request('POST', $this->url, $options);
            return $this->responseBuilder->success($res);
        } catch (Exception $e) {
            return $this->responseBuilder->errors($e);
        }
    }

    private function is_assoc($arr)
    {
        if (! is_array($arr)) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
