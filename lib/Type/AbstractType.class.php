<?php

namespace Seafile\Client\Type;

use DateTime;
use Doctrine\Common\Inflector\Inflector;
use stdClass;

/**
 * Abstract type class
 *
 * PHP version 5
 *
 * @category  API
 * @package   Seafile\Type
 * @author    Rene Schmidt DevOps UG (haftungsbeschränkt) & Co. KG <rene@reneschmidt.de>
 * @copyright 2015 Rene Schmidt DevOps UG (haftungsbeschränkt) & Co. KG <rene@reneschmidt.de>
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/rene-s/seafile-php-sdk
 */
abstract class AbstractType
{
    /**
     * Associative array mode
     */
    const ARRAY_ASSOC = 1;

    /**
     * Multipart array mode
     */
    const ARRAY_MULTI_PART = 2;

    /**
     * Constructor
     * @param array $fromArray Create from array
     */
    public function __construct(array $fromArray = [])
    {
        if (is_array($fromArray) && !empty($fromArray)) {
            $this->fromArray($fromArray);
        }
    }

    /**
     * Populate from array
     * @param array $fromArray Create from array
     * @return static
     */
    public function fromArray(array $fromArray)
    {
        foreach ($fromArray as $key => $value) {
            $lowerCamelCaseKey = Inflector::camelize($key);

            if (!property_exists($this, $lowerCamelCaseKey)) {
                continue;
            }

            switch ($key) {
                case 'create_time':
                    $value = floor($value / 1000000);
                    $this->{$lowerCamelCaseKey} = DateTime::createFromFormat("U", $value);
                    break;
                case 'mtime':
                case 'mtime_created':
                    $this->{$lowerCamelCaseKey} = DateTime::createFromFormat("U", $value);
                    break;
                default:
                    $this->{$lowerCamelCaseKey} = $value;
                    break;
            }
        }

        return $this;
    }

    /**
     * Create from jsonResponse
     * @param stdClass $jsonResponse Json response
     * @return static
     */
    public function fromJson(stdClass $jsonResponse)
    {
        $this->fromArray((array)$jsonResponse);
        return $this;
    }

    /**
     * Return instance as array
     *
     * @param int $mode Array mode
     *
     * @return array
     */
    public function toArray($mode = self::ARRAY_ASSOC)
    {
        switch ($mode) {
            case self::ARRAY_MULTI_PART:
                $keyVals = $this->toArray(self::ARRAY_ASSOC);
                $multiPart = [];

                foreach ($keyVals as $key => $val) {
                    $multiPart[] = ['name' => Inflector::tableize($key), 'contents' => "$val"];
                }

                $array = $multiPart;
                break;
            default:
                $array = array_filter((array)$this); // removes empty values
                break;
        }

        return $array;
    }

    /**
     * Return instance as JSON string
     *
     * @return string JSON string
     */
    public function toJson()
    {
        return json_encode($this);
    }
}