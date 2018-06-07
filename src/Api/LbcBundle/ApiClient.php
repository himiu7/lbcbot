<?php

namespace App\Api\LbcBundle;

use GuzzleHttp\Client;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;

class ApiClient extends GuzzleClient
{
    public static function factory($config = array())
    {
        $client = new Client([
            'base_url' => 'https://localbitcoins.com',
            'defaults' => [
                'cookies' => true,
                'timeout' => 15
            ]
        ]);

        $api = require (dirname(__FILE__) . '/Resources/api-desc.php');

        $description = new Description($api);

        $client->getEmitter()->on('before', function (BeforeEvent $event) use ($config){

            $key = $config['key'];
            $secret = $config['secret'];

            $req = $event->getRequest();

            // Set HMAC authorization before sending the request
            $nounce = time();
            $path = preg_replace('/\/{2,}/', '/', $req->getPath());

            $query = ('POST' == $req->getMethod()) ? $req->getBody()->getContents() : $req->getQuery();

            $sig = hash_hmac('sha256', $nounce . $key . $path . $query, $secret);

            $req->addHeaders([
                'Apiauth-Key' => $key,
                'Apiauth-Nonce' => $nounce,
                'Apiauth-Signature' => $sig
            ]);

        });

        $apiClient = new self($client, $description);

        return $apiClient;
    }

    /*public function execute(CommandInterface $command)
    {
        return parent::execute($command);
    }*/
}
