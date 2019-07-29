<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\ArgumentException;
use Com\PaulDevelop\Library\Common\TypeCheckException;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;
use Com\PaulDevelop\Library\Modeling\Entities\EntityCollection;
use Com\PaulDevelop\Library\Modeling\Entities\GenericEntityCollection;
use Com\PaulDevelop\Library\Modeling\Entities\IAttribute;
use Com\PaulDevelop\Library\Modeling\Entities\IEntity;
use Com\PaulDevelop\Library\Modeling\Entities\IProperty;
use Com\PaulDevelop\Library\Modeling\Entities\PropertyCollection;
use Exception;
use SimpleXMLElement;

class GenericParser
{
    public static function parse($projectFileName = '')
    {
        $projectAttributeCollection = new AttributeCollection();
        $project = simplexml_load_file($projectFileName);

        // project attributes
        $projectNamespaces = $project->getNamespaces(true);
        foreach ($projectNamespaces as $namespaceName => $namespaceUri) {
            $projectAttributes = $project->attributes($namespaceName, true);
            foreach ($projectAttributes as $key => $value) {
                echo $namespaceName . ' - ' . $key . ' - ' . $value . PHP_EOL;
                $projectAttributeCollection->add(
                    new Attribute($namespaceName, $key, (string)$value),
                    $namespaceName . ':' . $key
                );
            }
        }

        $genericEntity = self::parseGenericEntity($project);
        //var_dump($genericEntityCollection);
        //die;
        return $genericEntity;
//        // model attributes
//        $modelAttributeCollection = new AttributeCollection();
//        $model = $project->{'model'};
//        /** @var \SimpleXMLElement $model */
//        $modelNamespaces = $model->getNamespaces(true);
//        foreach ($modelNamespaces as $namespaceName => $namespaceUri) {
//            $modelAttributes = $model->attributes($namespaceName, true);
//            foreach ($modelAttributes as $key => $value) {
//                $modelAttributeCollection->add(
//                    new Attribute($namespaceName, $key, (string)$value),
//                    $namespaceName.':'.$key
//                );
//            }
//        }
//
//        // model entities
//        $modelEntityCollection = new EntityCollection();
//        foreach ($project->{'model'}->{'entity'} as $entity) {
//            $entityAttributeCollection = new AttributeCollection();
//            /** @var \SimpleXMLElement $entity */
//            $entityNamespaces = $entity->getNamespaces(true);
//            foreach ($entityNamespaces as $namespaceName => $namespaceUri) {
//                $entityAttributes = $entity->attributes($namespaceName, true);
//                foreach ($entityAttributes as $key => $value) {
//                    $entityAttributeCollection->add(
//                        new Attribute($namespaceName, $key, (string)$value),
//                        $namespaceName.':'.$key
//                    );
//                }
//            }
//
//            $entityPropertyCollection = new PropertyCollection();
//            foreach ($entity->{'property'} as $property) {
//                $propertyAttributeCollection = new AttributeCollection();
//                /** @var \SimpleXMLElement $property */
//                $propertyNamespaces = $property->getNamespaces(true);
//                foreach ($propertyNamespaces as $namespaceName => $namespaceUri) {
//                    $propertyAttributes = $property->attributes($namespaceName, true);
//                    foreach ($propertyAttributes as $key => $value) {
//                        $propertyAttributeCollection->add(
//                            new Attribute($namespaceName, $key, (string)$value),
//                            $namespaceName.':'.$key
//                        );
//                    }
//                }
//
//                $entityPropertyCollection->add(
//                    new Property(
//                        $propertyAttributeCollection['property:name']->Value,
//                        $propertyAttributeCollection
//                    ),
//                    $propertyAttributeCollection['property:name']->Value
//                );
//            }
//
//            $modelEntityCollection->add(
//                new Entity(
//                    $entityAttributeCollection['entity:namespace']->Value,
//                    $entityAttributeCollection['entity:name']->Value,
//                    $entityAttributeCollection,
//                    $entityPropertyCollection
//                ),
//                $entityAttributeCollection['entity:namespace']->Value
//                .'.'
//                .$entityAttributeCollection['entity:name']->Value
//            );
//        }

//        $genericEntityCollection = new GenericEntityCollection();
//
//        $project = new GenericProject(
//            $genericEntityCollection,
//            $projectAttributeCollection
//        );
//
//        return $project;
    }

    /**
     * @param SimpleXMLElement $genericEntity
     * @return GenericEntity
     * @throws ArgumentException
     * @throws TypeCheckException
     * @throws Exception
     */
    private static function parseGenericEntity(SimpleXMLElement $genericEntity)
    {
        //var_dump($genericEntity);
        echo "vvv " . $genericEntity->getName() . PHP_EOL;
        // generic element attributes
        $genericEntityAttributeCollection = new AttributeCollection();
        ///** @var \SimpleXMLElement $genericEntity */
        $entityNamespaces = $genericEntity->getNamespaces(true);
        foreach ($entityNamespaces as $namespaceName => $namespaceUri) {
            $entityAttributes = $genericEntity->attributes($namespaceName, true);
            foreach ($entityAttributes as $key => $value) {
                echo "    www " . $namespaceName . ":" . $key . " => " . $value . PHP_EOL;
                if (!array_key_exists($namespaceName . ':' . $key, $genericEntityAttributeCollection->getIterator())) {
                    $genericEntityAttributeCollection->add(
                        new Attribute($namespaceName, $key, (string)$value),
                        $namespaceName . ':' . $key
                    );
                }
            }
        }


        $result = new GenericEntity(
            $genericEntityAttributeCollection['entity:namespace']->Value,
            $genericEntityAttributeCollection['entity:name']->Value,
            $genericEntity->getName(),
            $genericEntityAttributeCollection,
            new GenericEntityCollection()
        );


        $genericEntityChildrenCollection = new GenericEntityCollection();
        foreach ($genericEntity->children() as $entityName => $entityElement) {
            echo $entityName . PHP_EOL;
            if (preg_match("/(.*?)List/", $entityName, $matches)) {
                echo "NOW LOOK FOR LIST ITEMS: " . $matches[1] . PHP_EOL;
                foreach ($entityElement->{$matches[1]} as $e) {
                    echo "    xxx " . $genericEntityAttributeCollection['entity:namespace']->Value . '.' . $genericEntityAttributeCollection['entity:name']->Value . PHP_EOL;
                    if (!array_key_exists($genericEntityAttributeCollection['entity:namespace']->Value . '.' . $genericEntityAttributeCollection['entity:name']->Value, $genericEntityChildrenCollection->getIterator())) {
                        $childrenGenericEntity = self::parseGenericEntity($e);
                        echo "    yyy " . $childrenGenericEntity->Attributes['entity:namespace']->Value . '.' . $childrenGenericEntity->Attributes['entity:name']->Value . PHP_EOL;
                        $genericEntityChildrenCollection->add(
                            $childrenGenericEntity,
                            $childrenGenericEntity->Attributes['entity:namespace']->Value
                            . '.'
                            . $childrenGenericEntity->Attributes['entity:name']->Value
//                            $genericEntityAttributeCollection['entity:namespace']->Value
//                            . '.'
//                            . $genericEntityAttributeCollection['entity:name']->Value
                        );
                    }
                }
            }
        }
        $result->ChildrenEntities = $genericEntityChildrenCollection;

        return $result;
    }

//    /**
//     * @param $entities
//     *
//     * @return EntityCollection
//     * @throws ArgumentException
//     * @throws TypeCheckException
//     */
//    private static function processEntityInheritation($entities)
//    {
//        // init
//        $result = new EntityCollection();
//
//        // action
//        $entitiesUsed = array(); // don't need to be in final entity list / to be generated
//
//        // iterate only entities with attribute "entity:extends"
//        foreach ($entities as $entity) {
//            /** @var IEntity $entity */
//            //echo $entity->Name.PHP_EOL;
//
//            // check, if attribute "entity:extends" exists
//            if ($entity->Attributes['entity:extends'] != null) {
//                //echo '  extends: '.$entity->Attributes['entity:extends']->Value.PHP_EOL;
//
//                // create new entity
//                $newEntity = new Entity();
//
//                // get inherited entity
//                $inheritedEntity = $entities[$entity->Attributes['entity:extends']->Value];
//                /** @var IEntity $inheritedEntity */
//
//                // mark current and inherited entity as used
//                if (!array_key_exists($inheritedEntity->Namespace . '.' . $inheritedEntity->Name, $entitiesUsed)) {
//                    $entitiesUsed[$inheritedEntity->Namespace . '.' . $inheritedEntity->Name] = 1;
//                }
//                if (!array_key_exists($entity->Namespace . '.' . $entity->Name, $entitiesUsed)) {
//                    $entitiesUsed[$entity->Namespace . '.' . $entity->Name] = 1;
//                }
//
//                // copy inherited properties
//                foreach ($inheritedEntity->Properties as $inheritedProperty) {
//                    /** @var IProperty $inheritedProperty */
//                    $newEntity->Properties->add($inheritedProperty, $inheritedProperty->Name);
//                }
//
//                // copy entity properties
//                foreach ($entity->Properties as $property) {
//                    /** @var IProperty $property */
//                    if ($newEntity->Properties[$property->Name] != null) {
//                        $newEntity->Properties[$property->Name] = $property;
//                    } else {
//                        $newEntity->Properties->add($property, $property->Name);
//                        //echo '  add property '.$property->Name.PHP_EOL;
//                    }
//                }
//
//                // copy inherited attributes
//                foreach ($inheritedEntity->Attributes as $inheritedAttribute) {
//                    /** @var IAttribute $inheritedAttribute */
//                    $newEntity->Attributes->add(
//                        $inheritedAttribute,
//                        $inheritedAttribute->Namespace . ':' . $inheritedAttribute->Key
//                    );
//                }
//
//                // overwrite them with entity attributes
//                foreach ($entity->Attributes as $attribute) {
//                    /** @var IAttribute $attribute */
//                    if ($newEntity->Attributes[$attribute->Namespace . ':' . $attribute->Key] != null) {
//                        $newEntity->Attributes[$attribute->Namespace . ':' . $attribute->Key] = $attribute;
//                    } else {
//                        $newEntity->Attributes->add(
//                            $attribute,
//                            $attribute->Namespace . ':' . $attribute->Key
//                        );
//                    }
//                }
//
//                // set namespace and name
//                $newEntity->Namespace = $entity->Namespace;
//                $newEntity->Name = $entity->Name;
//
//                $result->add($newEntity, $newEntity->Namespace . ':' . $newEntity->Name);
//            }
//        }
//
//        // iterate one more time, this time skip used entities
//        foreach ($entities as $entity) {
//            /** @var IEntity $entity */
//
//            // check, if not used
//            if (!array_key_exists($entity->Namespace . '.' . $entity->Name, $entitiesUsed)) {
//                $result->add($entity, $entity->Namespace . ':' . $entity->Name);
//            }
//        }
//
//        // return
//        return $result;
//    }
}