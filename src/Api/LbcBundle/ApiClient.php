<?php

namespace App\Api\LbcBundle;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;

/**
 * Class ApiClient
 * @package App\Api\LbcBundle
 *
 * Commands annotations : getCommands -> get Params
 *
 * @method accountInfo(array)
 * @method myself(array)
 * @method myAds(array)
 *
 * @method onlineBuy(array)
 * @method onlineBuyCountry(array)
 * @method onlineBuyCurrency(array)
 *
 * @method onlineSell(array)
 * @method onlineSellCountry(array)
 * @method onlineSellCurrency(array)
 *
 * @method adUpdate(array)
 * @method adUpdateEquation(array)
 *
 * @method chartAverage(array)
 * @method chartTrades(array)
 * @method chartOrders(array)
 */
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
            $req = $event->getRequest();
            $path = preg_replace('/\/{2,}/', '/', $req->getPath());
            $req->setPath($path);

            if (!empty($config['key']) && !empty($config['secret'])) {
                $key = $config['key'];
                $secret = $config['secret'];
    
                // Set HMAC authorization before sending the request
                $nounce = time();
                $query = ('POST' == $req->getMethod()) ? $req->getBody()->getContents() : $req->getQuery();
    
                $sig = hash_hmac('sha256', $nounce . $key . $path . $query, $secret);
    
                $req->addHeaders([
                    'Apiauth-Key' => $key,
                    'Apiauth-Nonce' => $nounce,
                    'Apiauth-Signature' => $sig
                ]);
            }
        });

        $apiClient = new self($client, $description);

        return $apiClient;
    }

    /*public function execute(CommandInterface $command)
    {
        return parent::execute($command);
    }*/
}
