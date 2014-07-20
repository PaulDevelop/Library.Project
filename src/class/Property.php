<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\IProperty;

/**
 * Class Property
 * @package Com\PaulDevelop\Library\Project
 *
 * @property string              $Name
 * @property AttributeCollection $Attributes
 */
class Property extends Base implements IProperty, IProjectNode
{
    #region member
    /**
     * @var string
     */
    private $name;

    /**
     * @var AttributeCollection
     */
    private $attributes;
    #endregion

    #region constructor
    /**
     * @param string              $name
     * @param AttributeCollection $attributes
     */
    public function __construct(
        $name = '',
        AttributeCollection $attributes = null
    ) {
        $this->name = $name;
        $this->attributes = $attributes != null ? $attributes
            : new AttributeCollection();
    }
    #endregion

    #region methods
    /**
     * @return IProjectNode
     */
    public function getNode()
    {
        // TODO: Implement getNode() method.
    }

    /**
     * @return ProjectNodeCollection
     */
    public function getNodeCollection()
    {
        // TODO: Implement getNodeCollection() method.
    }
    #endregion

    #region properties
    /**
     * Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     */
    public function setName($value = '')
    {
        $this->name = $value;
    }

    /**
     * GetAttributes
     *
     * @return AttributeCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    #endregion
}
