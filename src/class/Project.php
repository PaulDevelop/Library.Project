<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;

/**
 * /**
 * Class Project
 * @package Com\PaulDevelop\Library\Project
 * @property Model               $Model
 * @property AttributeCollection $Attributes
 */
class Project extends Base implements IProjectNode
{
    #region member
    /**
     * @var Model
     */
    private $model;

    /**
     * @var AttributeCollection
     */
    private $attributes;
    #endregion

    #region constructor
    public function __construct(
        Model $model = null,
        AttributeCollection $attributes = null
    ) {
        $this->model = $model;
        $this->attributes = $attributes != null ? $attributes
            : new AttributeCollection();
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
        /*
        $chunks = preg_split('/\./', $key, 0, PREG_SPLIT_NO_EMPTY);
        var_dump($chunks);

        $result = null;

        switch ( count($chunks) ) {
            case 1:
                if ( $chunks[0] == 'model') {
                    $result = $this->Model;
                }
        }

        if ( count($chunks) > 0 ) {

        }

        die;
        */

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
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
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
