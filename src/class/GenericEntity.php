<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\GenericEntityCollection;
use Com\PaulDevelop\Library\Modeling\Entities\IGenericEntity;

/**
 * Class GenericEntity
 * @package Com\PaulDevelop\Library\Project
 *
 * @property string $Namespace
 * @property string $Name
 * @property string $Type
 * @property AttributeCollection $Attributes
 * @property GenericEntityCollection $ChildrenEntities
 * @property GenericEntityCollection $ParentEntities
 */
class GenericEntity extends Base implements IGenericEntity, IProjectNode
{
    #region member
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var AttributeCollection
     */
    private $attributes;

    /**
     * @var GenericEntityCollection
     */
    private $parentEntities;

    /**
     * @var GenericEntityCollection
     */
    private $childrenEntities;
    #endregion

    #region constructor
    /**
     * @param string $namespace
     * @param string $name
     * @param string $type
     * @param AttributeCollection $attributes
     * @param GenericEntityCollection $childrenEntities
     * @param GenericEntityCollection $parentEntities
     * @throws \Exception
     */
    public function __construct(
        $namespace = '',
        $name = '',
        $type = '',
        AttributeCollection $attributes = null,
        GenericEntityCollection $childrenEntities = null,
        GenericEntityCollection $parentEntities = null
    )
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->type = $type;
        $this->attributes = $attributes != null ? $attributes : new AttributeCollection();
        $this->childrenEntities = $childrenEntities != null ? $childrenEntities : new GenericEntityCollection();
        $this->parentEntities = $parentEntities != null ? $parentEntities : new GenericEntityCollection();
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
     * Namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $value
     */
    public function setNamespace($value = '')
    {
        $this->namespace = $value;
    }

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
     * Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $value
     */
    public function setType($value = '')
    {
        $this->type = $value;
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

//    /**
//     * Properties.
//     *
//     * @return PropertyCollection
//     */
//    public function getProperties()
//    {
//        return $this->properties;
//    }

    /**
     * Parent entities.
     *
     * @return GenericEntityCollection
     */
    public function getParentEntities()
    {
        return $this->parentEntities;
    }
    #endregion

    /**
     * @return boolean
     */
    public function hasChildren()
    {
        return $this->childrenEntities->Count == 0 ? false : true;
    }

    /**
     * @return GenericEntityCollection
     */
    public function getChildrenList()
    {
        return $this->childrenEntities;
    }

    /**
     * @param $name
     * @return IGenericEntity
     */
    public function getChildren($name)
    {
        // TODO: Implement getChildren() method.
        //$this->childrenEntities->getIterator()
        //return $this->childrenEntities[""];
    }

    /**
     * @return GenericEntityCollection
     */
    public function getChildrenEntities()
    {
        return $this->childrenEntities;
    }

    /**
     * @param GenericEntityCollection $value
     */
    public function setChildrenEntities(GenericEntityCollection $value)
    {
        $this->childrenEntities = $value;
    }
}
