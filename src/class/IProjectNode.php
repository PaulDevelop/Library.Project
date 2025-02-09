<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Modeling\Entities\AttributeCollection;

/**
 * Interface IProjectNode
 * @package Com\PaulDevelop\Library\Project
 * @property AttributeCollection $Attributes
 */
interface IProjectNode
{
    /**
     * @param string $path
     * @return IProjectNode
     */
    public function getNode(string $path = ''): IProjectNode;

    /**
     * @param string $path
     * @return ProjectNodeCollection
     */
    public function getNodeCollection(string $path = ''): ProjectNodeCollection;

    /**
     * GetAttributes
     *
     * @return AttributeCollection
     */
    public function getAttributes();
}
