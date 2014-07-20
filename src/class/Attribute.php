<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Modeling\Entities\IAttribute;

/**
 * Class Attribute
 * @package Com\PaulDevelop\Library\Project
 *
 * @property string $Namespace
 * @property string $Key
 * @property string $Value
 */
class Attribute extends Base implements IAttribute
{
    #region member
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;
    #endregion

    #region constructor
    public function __construct($namespace = '', $key = '', $value = '')
    {
        $this->namespace = $namespace;
        $this->key = $key;
        $this->value = $value;
    }
    #endregion

    #region properties
    /**
     * Namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    #endregion
}
