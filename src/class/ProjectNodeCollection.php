<?php

namespace Com\PaulDevelop\Library\Project;

use Com\PaulDevelop\Library\Common\GenericCollection;

class ProjectNodeCollection extends GenericCollection
{
    public function __construct()
    {
        parent::__construct('\Com\PaulDevelop\Library\Project\IProjectNode');
    }
}
