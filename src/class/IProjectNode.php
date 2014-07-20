<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;

/**
 * Interface IProjectNode
 * @package Com\PaulDevelop\Library\Project
 * @property \Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection $Attributes
 */
interface IProjectNode
{
    /**
     * @return IProjectNode
     */
    public function getNode();

    /**
     * @return ProjectNodeCollection
     */
    public function getNodeCollection();

    /**
     * GetAttributes
     *
     * @return AttributeCollection
     */
    public function getAttributes();
}
