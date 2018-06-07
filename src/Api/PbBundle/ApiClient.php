<?php

namespace App\Api\PbBundle;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use App\Api\PbBundle\Model\Request as PbRequest;

class ApiClient
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var PbRequest;
     */
    private $request;

    public function __construct(PbRequest $request = null)
    {
        $this->client = new Client();
        $this->request = $request;
    }

    /**
     * @param PbRequest|null $request
     * @return string
     */
    public function send(PbRequest $request = null)
    {
        if (!$request) {
            $model = $this->request;
        }
        /** @var Request */
        $request = $this->client->createRequest('POST', $model->getUrl());
        $request->addHeader('Content-Type', 'text/xml; charset=UTF8');
        $request->setBody($model->getXml());
        /** @var Response */
        $response = $this->client->send($request);

        return $response->getBody()->getContents();
    }
}
