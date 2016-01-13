<?php

namespace Majora\Component\Graph\Engine;

use Majora\Component\Graph\Engine\OrientDbEngine;

/**
 * Interface to implement on services which needs an OrientDb connection
 */
interface GraphClientInterface
{
    /**
     * Define graph connection which object are waiting for
     *
     * @param string         $vertexClass
     * @param OrientDbEngine $orientDb
     * @param string         $connection connection name
     */
    public function setGraphDatabase($vertexClass, OrientDbEngine $orientDb, $connection);
}
