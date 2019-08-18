<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\ArgumentException;
use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\TypeCheckException;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\GenericEntityCollection;
use Com\PaulDevelop\Library\Modeling\Entities\IGenericEntity;
use Exception;

/**
 * Class GenericEntity
 * @package Com\PaulDevelop\Library\Project
 *
 * @property string $Namespace
 * @property string $Name
 * @property string $Type
 * @property AttributeCollection $Attributes
 * @property GenericEntityCollection $ChildrenEntities
 * @property GenericEntity $ParentGenericEntity
 * @property boolean $IsListItem
 */
//* @property string              $ReferencingPropertyName
//* @property GenericEntityCollection $ParentEntities
class GenericEntity extends Base implements IGenericEntity, IProjectNode
{
    #region member
    /**
     * @var string
     */
    private string $namespace;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var AttributeCollection
     */
    private $attributes;

//    /**
//     * @var string
//     */
//    private $referencingPropertyName;

//    /**
//     * @var GenericEntityCollection
//     */
//    private $referencedParentEntities;

    /**
     * @var GenericEntity
     */
    private $parentGenericEntity;

    /**
     * @var GenericEntityCollection
     */
    private $childrenEntities;

    /**
     * @var boolean
     */
    private $isListItem;
    #endregion

    #region constructor
    /**
     * @param string $namespace
     * @param string $name
     * @param string $type
     * @param AttributeCollection $attributes
     * @param GenericEntityCollection $childrenEntities
     * @param GenericEntity $parentGenericEntity
     * @param boolean $isListItem
     * @throws Exception
     */
//* @param string              $referencingPropertyName
//* @param GenericEntityCollection $parentEntities
    public function __construct(
        $namespace = '',
        $name = '',
        $type = '',
        AttributeCollection $attributes = null,
        GenericEntityCollection $childrenEntities = null,
//        $referencingPropertyName = '',
//        GenericEntityCollection $parentEntities = null
        GenericEntity $parentGenericEntity = null,
        $isListItem = false
    )
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->type = $type;
        $this->attributes = $attributes != null ? $attributes : new AttributeCollection();
        $this->childrenEntities = $childrenEntities != null ? $childrenEntities : new GenericEntityCollection();
//        $this->referencingPropertyName = $referencingPropertyName;
//        $this->parentEntities = $parentEntities != null ? $parentEntities : new GenericEntityCollection();
        $this->parentGenericEntity = $parentGenericEntity;
        $this->isListItem = $isListItem;
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

//    /**
//     * Referencing property name
//     *
//     * @return string
//     */
//    public function getReferencingPropertyName()
//    {
//        return $this->referencingPropertyName;
//    }
//
//    /**
//     * @param string $value
//     */
//    public function setReferencingPropertyName($value = '')
//    {
//        $this->referencingPropertyName = $value;
//    }

//    /**
//     * Parent entities.
//     *
//     * @return GenericEntityCollection
//     */
//    public function getParentEntities()
//    {
//        return $this->parentEntities;
//    }
//    #endregion

    /**
     * Parent generic entity.
     *
     * @return GenericEntity
     */
    public function getParentGenericEntity()
    {
        return $this->parentGenericEntity;
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
     * @param string $type
     * @return GenericEntityCollection
     * @throws ArgumentException
     * @throws TypeCheckException
     */
    public function getChildrenListByType($type = '')
    {
        $result = new GenericEntityCollection();
        foreach ( $this->childrenEntities as $key => $entity ) {
            if ( $entity->Type == $type ) {
                $result->add($entity, $key);
            }
        }
        return $result;
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

    /**
     * @return bool
     */
    public function GetIsListItem(): bool
    {
        return $this->isListItem;
    }

    /**
     * @param bool $value
     */
    public function SetIsListItem(bool $value): void
    {
        $this->isListItem = $value;
    }
}
