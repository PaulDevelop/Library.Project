<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\GenericEntityCollection;

/**
 * /**
 * Class GenericProject
 * @package Com\PaulDevelop\Library\Project
 * @property Model               $Model
 * @property AttributeCollection $Attributes
 */
class GenericProject extends Base implements IProjectNode
{
    #region member
    /**
     * @var GenericEntityCollection
     */
    private $genericEntityList;

    /**
     * @var AttributeCollection
     */
    private $attributes;
    #endregion

    #region constructor
    public function __construct(
        GenericEntityCollection $genericEntityList = null,
        AttributeCollection $attributes = null
    ) {
        $this->genericEntityList = $genericEntityList;
        $this->attributes = $attributes != null ? $attributes : new AttributeCollection();
    }
    #endregion

    #region methods
    /**
     * @param string $key
     *
     * @return IProjectNode
     */
    public function getNode($key = '')
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
     * @return GenericEntityCollection
     */
    public function getGenericEntityList()
    {
        return $this->genericEntityList;
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
