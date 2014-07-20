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

    /*
    public function getNode($path)
    {
        // init
        $chunks = $this->splitPath($path);

        // action
        $curObj = $this;
        foreach ($chunks as $chunk) {
            // check, if attributes exist
            $regs = array();
            preg_match('/^([a-z]+)(?:\[(.*)\])?$/i', $chunk, $regs);

            // if there are attributes, store them in array
            $chunkAttributes = array();
            if (sizeof($regs) > 2) {
                // get chunk name
                $chunk = $regs[1];

                // get attributes
                $tmpAttributes = preg_split('/\,/', $regs[2]);
                for ($i = 0; $i < sizeof($tmpAttributes); $i++) {
                    list($key, $value) = preg_split('/\=/', $tmpAttributes[$i]); // split into key = value
                    $key = substr($key, 1, strlen($key) - 1); // remove @
                    $value = trim($value, '\''); // remove ''
                    $chunkAttributes[$key] = $value; // add to attributes list
                }
            }

            if (($curObj = $curObj->getChildNode($chunk, $chunkAttributes)) != null) {
                // zuweisung schon oben in if-block schon erfolgt
            } else {
                throw new ChildDoesNotExistException('Child node "'.$chunk.'" '.' ("'.$path.'") does not exist.');
            }
        }

        // return
        return $curObj;
    }
    */

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
