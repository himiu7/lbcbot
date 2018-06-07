<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 07.06.2018
 * Time: 12:38
 */

namespace App\Api\PbBundle\Model;


abstract class Request
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $password;

    /**
     * @return string
     */
    public function getSignature()
    {
        return sha1(md5($this->data().$this->password));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * return string Xml Request Body
     */
    public function getXml()
    {
        return <<< XML
<?xml version="1.0" encoding="UTF-8"?>
<request version="1.0">
    <merchant>
        <id>{$this->id}</id>
        <signature>{$this->getSignature()}</signature>
    </merchant>
    <data>{$this->data()}</data>
</request>
XML;
    }

    /**
     * @return strng Xml <data> block
     */
    abstract protected function data();

    /**
     * @return string Api Url
     */
    abstract public function getUrl();
}