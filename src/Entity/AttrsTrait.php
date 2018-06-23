<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 10.06.2018
 * Time: 13:39
 */

namespace App\Entity;

interface AttrsInterface
{
    public function setAttrs(array $attrs);
    public function getAttrs($attr=null);
}
/**
 * Class AttrsTrait
 * @package App\Entity
 */
trait AttrsTrait
{
    /**
     * @param array $attrs
     * @param array $embed Embed params classes to create
     * @return $this
     */
    public function setAttrs(array $attrs, array $embed = [])
    {
        foreach ($attrs as $field => $value) {

            if (!empty($embed[$field]) && is_array($attrs[$field])) {
                $this->$field = new $embed[$field];
                $this->$field->setAttrs($value, $embed);
            } else {
                $this->$field = $value;
            }
        }

        return $this;
    }

    /**
     * @param array|string $attr
     * @return array|mixed
     */
    public function getAttrs($attr=null)
    {

        $result = [];

        if (!empty($attr)) {
            if (is_array($attr)) {

                foreach ($attr as $field) {
                    $result[$field] = $this->$field;
                }
            } else {
                return $this->$attr;
            }
        } else {

            foreach (get_object_vars($this) as $attr => $val) {
                $result[$attr] = $val;
            }
        }

        return $result;
    }

    /**
     * @param array $formatAttrs
     * @return string
     */
    public function printAttrs(array $formatAttrs)
    {
        $result=[];

        foreach ($formatAttrs as $format => $attr) {

            $result[] = sprintf($format, $attr);
        }

        return implode(',', $result);
    }
}