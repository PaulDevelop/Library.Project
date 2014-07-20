<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\EntityCollection;

/**
 * Class Model
 * @package Com\PaulDevelop\Library\Project
 * @property EntityCollection    $Entities
 * @property AttributeCollection $Attributes
 */
class Model extends Base implements IProjectNode
{
    #region member
    /**
     * @var EntityCollection
     */
    private $entities;

    /**
     * @var AttributeCollection
     */
    private $attributes;
    #endregion

    #region constructor
    public function __construct(
        EntityCollection $entities = null,
        AttributeCollection $attributes = null
    ) {
        $this->entities = $entities;
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
     * @return EntityCollection
     */
    public function getEntities()
    {
        return $this->entities;
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
