<?php
/**
 * Created by PhpStorm.
 * User: himius
 * Date: 23.06.2018
 * Time: 11:57
 */

namespace App\Api\LbcBundle;

interface ApiProfileInterface
{
    public function getId();

    public function getKey();

    public function setKey(string $key);

    public function getSecret();

    public function setSecret(string $secret);

    public function getLastAdsUpdate();

    public function setLastAdsUpdate(\DateTime $lastAdsUpdate);
}
