<?php

namespace Majora\Component\Graph\Entity;

/**
 * Interface to implement on entities which can bo persist into a graph database
 */
interface GraphableInterface
{
    /**
     * Define entity record id
     *
     * @param int $recordId
     *
     * @return GraphableInterface
     */
    public function setRecordId($recordId);

    /**
     * Returns entity record id
     *
     * @return int
     */
    public function getRecordId();

    /**
     * Returns entity scope name which has to be used into graph
     *
     * @return string
     */
    public function getGraphScope();
}
