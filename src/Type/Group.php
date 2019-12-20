<?php

namespace Seafile\Client\Type;

use \Seafile\Client\Type\Account as AccountType;
use stdClass;

/**
 * Group type class
 *
 * @package   Seafile\Type
 * @author    Rene Schmidt DevOps UG (haftungsbeschränkt) & Co. KG <rene+_seafile_github@sdo.sh>
 * @copyright 2015-2017 Rene Schmidt DevOps UG (haftungsbeschränkt) & Co. KG <rene+_seafile_github@sdo.sh>
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/rene-s/seafile-php-sdk
 * @method Group fromJson(stdClass $jsonResponse)
 * @method Group fromArray(array $fromArray)
 */
class Group extends Type
{
    /**
     * @var int|null
     */
    public $ctime = null;

    /**
     * @var AccountType|null
     */
    public $creator = null;

    /**
     * @var int|null
     */
    public $msgnum = null;

    /**
     * @var int|null
     */
    public $mtime = null;

    /**
     * @var int|null
     */
    public $id = null;

    /**
     * @var string|null
     */
    public $name = null;
}
