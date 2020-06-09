<?php


namespace Subbe\WaveApp;

class ResponseBuilder
{
    public function success($res)
    {
        return json_decode($res->getBody(), 1);
    }

    public function errors($e)
    {
        if ($e->hasResponse()) {
            $response = json_decode($e->getResponse()->getBody(), 1);
            return $response['errors'];
        }
        return $e->getMessage();
    }
}
