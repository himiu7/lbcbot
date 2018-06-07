<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 07.06.2018
 * Time: 12:52
 */

namespace App\Api\PbBundle\Model;

use App\Api\PbBundle\Model\Request;

class PayPb extends Request
{
    /**
     * @var int Timeout [0 - 90]
     */
    protected $wait = 0;
    /**
     * @var int Test mode [0,1]
     */
    protected $test = 0;
    /**
     * @var string
     */
    protected $payment_id = "";
    /**
     * @var string Card number
     */
    private $b_card_or_acc;
    /**
     * @var string Price Decimal e.g.: 20.55
     */
    private $amt;
    /**
     * @var string Currency [UAH, RUR etc]
     */
    private $ccy;
    /**
     * @var string
     */
    private $details;

    /**
     * @return int
     */
    public function getWait()
    {
        return $this->wait;
    }

    /**
     * @param int $wait
     */
    public function setWait($wait)
    {
        $this->wait = $wait;
    }

    /**
     * @return int
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param int $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }

    /**
     * @return string
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * @param string $payment_id
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    /**
     * @return string
     */
    public function getBCardOrAcc()
    {
        return $this->b_card_or_acc;
    }

    /**
     * @param string $b_card_or_acc
     */
    public function setBCardOrAcc($b_card_or_acc)
    {
        $this->b_card_or_acc = $b_card_or_acc;
    }

    /**
     * @return string
     */
    public function getAmt()
    {
        return $this->amt;
    }

    /**
     * @param string $amt
     */
    public function setAmt($amt)
    {
        $this->amt = $amt;
    }

    /**
     * @return string
     */
    public function getCcy()
    {
        return $this->ccy;
    }

    /**
     * @param string $ccy
     */
    public function setCcy($ccy)
    {
        $this->ccy = $ccy;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }
    protected function data()
    {
        return <<<XML
    <oper>cmt</oper>
    <wait>{$this->wait}</wait>
    <test>{$this->test}</test>
    <payment id="{$this->payment_id}">
        <prop name="b_card_or_acc" value="{$this->b_card_or_acc}" />
        <prop name="amt" value="{$this->amt}" />
        <prop name="ccy" value="{$this->ccy}" />
        <prop name="details" value="{$this->details}" />
    </payment>
XML;
    }

    public function getUrl()
    {
        return 'https://api.privatbank.ua/p24api/pay_pb';
    }
}