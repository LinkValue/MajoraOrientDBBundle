<?php

namespace Majora\Component\Graph\Entity;

/**
 * Trait which implements GraphableInterface
 *
 * @see Majora\Component\Graph\Entity\GraphableInterface
 */
trait GraphableTrait
{
    /**
     * @var int
     */
    protected $recordId;

    /**
     * @see GraphableInterface::setRecordId()
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;

        return $this;
    }

    /**
     * @see GraphableInterface::getRecordId()
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * @see GraphableInterface::getGraphScope()
     */
    public function getGraphScope()
    {
        return 'vertex';
    }
}
