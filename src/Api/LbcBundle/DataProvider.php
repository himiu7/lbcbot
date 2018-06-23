<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 13.06.2018
 * Time: 18:22
 */

namespace App\Api\LbcBundle;

use App\Api\LbcBundle\ApiClient;
use App\Document\Trade;
use App\Entity\AttrsInterface;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\Guzzle\Parameter;

class DataProvider
{
    const LIST_SELL  = 'sell';
    const LIST_BUY  = 'buy';
    const LIST_USER  = 'user';

    /**
     * @var string ['SELL' | 'BUY' | 'USER']
     */
    private $type;
    /**
     * @var string
     */
    protected $modelClass;
    /**
     * @var array
     */
    protected $embedClass = [];
    /**
     * @var ArrayCollection
     */
    protected $data;
    /**
     * @var Pagination
     */
    protected $pagination;
    /**
     * @var Operation[]
     */
    private static $api = [];
    /**
     * DataProvider constructor.
     * @param string $type
     * @param string $modelClass
     * @param array $embedClass
     */
    public function __construct($type, $modelClass, $embedClass = [])
    {
        $this->modelClass = $modelClass;
        $this->data = new ArrayCollection();

        if (!self::$api) {
            self::$api = ApiClient::factory()->getDescription()->getOperations();
        }

        $this->type = strtolower($type);
        $this->embedClass = $embedClass;
    }

    /**
     * @param array $params
     * @throws \Exception
     * @return ArrayCollection
     */
    public function getData(array $params=[])
    {
        $_params = [];
        $this->pagination = null;

        if (!empty($params['page'])) {
            $_params['page'] = $params['page'];
        }

        if (!empty($params['fields'])) {

            if (is_array($params['fields'])) {
                $_params['fields'] = implode(',', $params['fields']);
            } else {
                $_params['fields'] = $params['fields'];
            }

            unset($params['fields']);
        }
        /** @var ApiClient $client */
        $client = null;

        switch ($this->type) {
            case Trade::TRADE_SELL:
            case Trade::TRADE_BUY:

                $cmd = $this->type == Trade::TRADE_BUY ? 'onlineBuy' : 'onlineSell';

                if (!empty($params['currency'])) {
                    $cmd .= 'Currency';
                    $_params['currency'] = $params['currency'];

                } elseif (!empty($params['country'])
                    && !empty($params['countrycode'])
                ) {
                    $cmd .= 'Country';
                    $_params['country_name'] = strtolower(str_replace(' ', '_', $params['country']));
                    $_params['countrycode'] = strtoupper($params['countrycode']);
                }

                $client = ApiClient::factory();
                break;

            case Trade::TRADE_USER:
                $cmd = 'myAds';

                if (empty($params['key']) || empty($params['secret'])) {
                    throw new \Exception('Auth required');
                }

                $client = ApiClient::factory([
                   'key' => $params['key'],
                   'secret' => $params['secret']
                ]);

                /** @var Parameter[] $pars */
                $pars = $client->getDescription()->getOperation($cmd)->getParams();

                foreach ($pars as $par) {

                    if (!empty($params[$par->getName()])) {
                        $_params[$par->getName()] = $params[$par->getName()];
                    }
                }
                break;
        }

        if ($client) {
            $res = $client->$cmd($_params);

            if (!empty($res['data']) && !empty($res['data']['ad_list'])) {

                foreach ($res['data']['ad_list'] as $ad) {
                    /** @var AttrsInterface $model */
                    $model = new $this->modelClass;

                    $model->setAttrs($ad['data'], $this->embedClass);
                    $this->data->add($model);
                }
                
                if (!empty($res['pagination'])) {
                    
                    $this->pagination = new Pagination();
                    
                    if (!empty($res['pagination']['next'])) {
                        $this->pagination->setNext($res['pagination']['next']);
                    }
                    if (!empty($res['pagination']['prev'])) {
                        $this->pagination->setNext($res['pagination']['prev']);
                    }
                }
                return $this->data;
            }
        }
    }

    public function getPagination()
    {
        return $this->pagination;
    }
}

class Pagination
{
    /**
     * @var string
     */
    protected $next;
    /**
     * @var string
     */
    protected $prev;

    private function fromUrl($url)
    {
        if (preg_match('#^[^\?]+\?(.*)page=(\d+)#i', $url, $parts)) {
            
            if (!empty($parts[2])) {
                return $parts[2];
            }
        }
        
        return false;
    }
    /**
     * @return string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param string $next
     * @return $this
     */
    public function setNext($next)
    {
        $this->next = $this->fromUrl($next) ?? $next;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * @param string $prev
     * @return $this
     */
    public function setPrev($prev)
    {
        $this->prev = $this->fromUrl($prev) ?? $prev;
        
        return $this;
    }
}
