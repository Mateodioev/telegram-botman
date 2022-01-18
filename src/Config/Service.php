<?php

namespace App\Config;

use GuzzleHttp\Client;

class Service {

    /**
     * Guzzle client.
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    public function __construct($cacert = './../cacert.pem')
    {
        if (!file_exists($cacert)) {
            return throw new \Exception('cacert.pem not found');
        }
        $this->client = new Client(['verify' => $cacert]);
        return $this;
    }

}