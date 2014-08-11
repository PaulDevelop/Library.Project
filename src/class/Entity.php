<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\EntityCollection;
use Com\PaulDevelop\Library\Modeling\Entities\IEntity;
use Com\PaulDevelop\Library\Modeling\Entities\IProperty;
use Com\PaulDevelop\Library\Modeling\Entities\PropertyCollection;

/**
 * Class Entity
 * @package Com\PaulDevelop\Library\Project
 *
 * @property string              $Namespace
 * @property string              $Name
 * @property AttributeCollection $Attributes
 * @property PropertyCollection  $Properties
 * @property string              $ReferencingPropertyName
 * @property EntityCollection    $ParentEntities
 */
class Entity extends Base implements IEntity, IProjectNode
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
     * @var AttributeCollection
     */
    private $attributes;

    /**
     * @var PropertyCollection
     */
    private $properties;

    /**
     * @var string
     */
    private $referencingPropertyName;

    /**
     * @var EntityCollection
     */
    private $parentEntities;
    #endregion

    #region constructor
    /**
     * @param string              $namespace
     * @param string              $name
     * @param AttributeCollection $attributes
     * @param PropertyCollection  $properties
     * @param string              $referencingPropertyName
     * @param EntityCollection  $parentEntities
     */
    public function __construct(
        $namespace = '',
        $name = '',
        AttributeCollection $attributes = null,
        PropertyCollection $properties = null,
        $referencingPropertyName = '',
        EntityCollection $parentEntities = null
    ) {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->attributes = $attributes != null ? $attributes : new AttributeCollection();
        $this->properties = $properties != null ? $properties : new PropertyCollection();
        $this->referencingPropertyName = $referencingPropertyName;
        $this->parentEntities = $parentEntities != null ? $parentEntities : new EntityCollection();
    }
    #endregion

    #region methods
    /**
     * HasProperty.
     *
     * @param string $propertyName
     *
     * @return boolean
     */
    public function hasProperty($propertyName)
    {
        // TODO: Implement hasProperty() method.
    }

    /**
     * GetProperty.
     *
     * @param string $propertyName
     *
     * @return IProperty
     */
    public function getProperty($propertyName)
    {
        // TODO: Implement getProperty() method.
    }

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
     * GetAttributes
     *
     * @return AttributeCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Properties.
     *
     * @return PropertyCollection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Referencing property name
     *
     * @return string
     */
    public function getReferencingPropertyName()
    {
        return $this->referencingPropertyName;
    }

    /**
     * @param string $value
     */
    public function setReferencingPropertyName($value = '')
    {
        $this->referencingPropertyName = $value;
    }

    /**
     * Parent entities.
     *
     * @return EntityCollection
     */
    public function getParentEntities()
    {
        return $this->parentEntities;
    }
    #endregion
}
