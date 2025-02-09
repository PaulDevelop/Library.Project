<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\ArgumentException;
use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\TypeCheckException;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\GenericEntityCollection;
use Com\PaulDevelop\Library\Modeling\Entities\IGenericEntity;
//use Com\PaulDevelop\Library\Template\ChildDoesNotExistException;
//use Com\PaulDevelop\Tool\Generator\MultipleNodesFoundException;
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
     * @param string $path
     * @return IProjectNode
     */
    public function getNode(string $path = ''): IProjectNode
    {
        // init
        $result = $this;

        // action
        $chunks = $this->splitPath($path);
        // each chunk is another depth level
        // we need to go through the children nodes of the current node and check if the expression matches
        // if yes, we can go into the next depth level until we reach the end of the query in $key (which is, the last chunk)
        // if we reach the end of the query, we can return the node
        //foreach ($chunks as $chunk) {
        //    // find nodes
        //    $result = $this->childrenEntities->get($chunk);
        // }

        // check current node
        //if ( count($chunks) > 0 ) {
        foreach ($chunks as $chunk) {

            $regs = array();
            preg_match('/^([a-z]+)(?:\[(.*)\])?$/i', $chunk, $regs);

            // if there are attributes, store them in array
            $chunkAttributes = array();
            if (sizeof($regs) > 2) {
                // get chunk name
                $chunkEntityType = $regs[1];

                // get attributes
                $tmpAttributes = preg_split('/\,/', $regs[2]);
                for ($i = 0; $i < sizeof($tmpAttributes); $i++) {
                    list($key, $value) = preg_split('/\=/', $tmpAttributes[$i]); // split into key = value
                    $key = substr($key, 1, strlen($key) - 1); // remove @
                    $value = trim($value, '\''); // remove ''
                    $chunkAttributes[$key] = $value; // add to attributes list
                }
            }

            //  now check for children nodes
            $count = 0;
            //foreach ( $result->ChildrenEntities as $childrenEntity ) {
            //    $cet = $childrenEntity->Type;
            foreach ( $result->getChildrenListByType($chunkEntityType) as $childrenEntity ) {
                $allAttributesAreOk = true;
                foreach ( $chunkAttributes as $key => $value ) {
                    $an = $key;
                    if ( strpos($key, ':') > 0 ) {
                        list($namespace, $name) = preg_split('/\:/', $key);
                        $an = $namespace.':'.$name;
                    }
                    //list($namespace, $name) = preg_split('/\:/', $key);
//                    if ( $childrenEntity->Attributes[$namespace.':'.$name] != null
//                        && $childrenEntity->Attributes[$namespace.':'.$name]->Value != $value ) {
//                        $allAttributesAreOk = false;
//                        break;
//                    }

                    //$cea = $childrenEntity->Attributes[$an];
                    //$ceav = $childrenEntity->Attributes[$an]->Value;

                    if ($childrenEntity->Attributes[$an] == null
                        || ($childrenEntity->Attributes[$an] != null
                            && $childrenEntity->Attributes[$an]->Value != $value) ) {
                        $allAttributesAreOk = false;
                        break;
                    }
                }
                if ( $allAttributesAreOk ) {
                    $count++;
                    if ($count > 1) {
                        throw new Exception( // MultipleNodesFoundException(
                            'Multiple nodes found for key: '.$key
                        );
                    }
                    $result = $childrenEntity;
                }
            }
            if ( $count == 0 ) {
                throw new Exception( // ChildDoesNotExistException(
                    'No node found for key: '.$key
                );
            }
        }

        // return
        return $result;
    }

    /**
     * @param string $path
     * @return ProjectNodeCollection
     */
    public function getNodeCollection(string $path = ''): ProjectNodeCollection
    {
        // init
        $result = new ProjectNodeCollection();

        // action
        $currentNode = $this;
        $chunks = $this->splitPath($path);

        // check current node
        //if ( count($chunks) > 0 ) {
        $countChunks = 0;
        foreach ($chunks as $chunk) {

            $regs = array();
            preg_match('/^([a-z]+)(?:\[(.*)\])?$/i', $chunk, $regs);

            // if there are attributes, store them in array
            $chunkAttributes = array();
            // get chunk name
            $chunkEntityType = $regs[1];
            if (sizeof($regs) > 2) {

                // get attributes
                $tmpAttributes = preg_split('/\,/', $regs[2]);
                for ($i = 0; $i < sizeof($tmpAttributes); $i++) {
                    list($key, $value) = preg_split('/\=/', $tmpAttributes[$i]); // split into key = value
                    $key = substr($key, 1, strlen($key) - 1); // remove @
                    $value = trim($value, '\''); // remove ''
                    $chunkAttributes[$key] = $value; // add to attributes list
                }
            }

            //  now check for children nodes
            $count = 0;
            //foreach ( $result->ChildrenEntities as $childrenEntity ) {
            //    $cet = $childrenEntity->Type;
            foreach ( $currentNode->getChildrenListByType($chunkEntityType) as $childrenEntity ) {
                $allAttributesAreOk = true;
                foreach ( $chunkAttributes as $key => $value ) {
                    $an = $key;
                    if ( strpos($key, ':') > 0 ) {
                        list($namespace, $name) = preg_split('/\:/', $key);
                        $an = $namespace.':'.$name;
                    }
                    //list($namespace, $name) = preg_split('/\:/', $key);
//                    if ( $childrenEntity->Attributes[$namespace.':'.$name] != null
//                        && $childrenEntity->Attributes[$namespace.':'.$name]->Value != $value ) {
//                        $allAttributesAreOk = false;
//                        break;
//                    }

                    //$cea = $childrenEntity->Attributes[$an];
                    //$ceav = $childrenEntity->Attributes[$an]->Value;

                    if ($childrenEntity->Attributes[$an] == null
                        || ($childrenEntity->Attributes[$an] != null
                            && $childrenEntity->Attributes[$an]->Value != $value) ) {
                        $allAttributesAreOk = false;
                        break;
                    }
                }
                if ( $allAttributesAreOk ) {


                    $count++;
                    if ( $countChunks == count($chunks) - 1 ) {
                        $result->add($childrenEntity);
                    }
                    else {
                        if ($count > 1) {
                            throw new Exception( // MultipleNodesFoundException(
                                'Multiple nodes found for key: '.$key
                            );
                        }
                        $currentNode = $childrenEntity;
                    }
                }
            }
            if ( $count == 0 ) {
                throw new Exception( // ChildDoesNotExistException(
                    'No node found for key: '.$key
                );
            }
            $countChunks++;
        }

        // return
        return $result;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private function splitPath(string $path = ''): array
    {
        // init
        $textDelimiter = '\'';
        $pathDelimiter = '.';
        $result = array();

        // action
        $stringIsOpen = false;
        $currentChunk = '';
        for ($i = 0; $i < strlen($path); $i++) {
            $currentSymbol = $path[$i];

            if ($currentSymbol == $textDelimiter) {
                $stringIsOpen = !$stringIsOpen;
            }

            if ($currentSymbol == $pathDelimiter && !$stringIsOpen) {
                if ($currentChunk != '') {
                    $result[count($result)] = $currentChunk;
                }
                $currentChunk = '';
                continue;
            }
            $currentChunk .= $currentSymbol;
        }

        if ($currentChunk != '') {
            $result[count($result)] = $currentChunk;
        }

        // return
        return $result;
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
