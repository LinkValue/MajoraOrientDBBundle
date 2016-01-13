<?php

namespace Majora\Component\Graph\Vertex;

/**
 * Value object for OrientDb vertexes
 */
class Vertex
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $sequence;

    /**
     * construct
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->sequence = sprintf('%s_id_seq', strtolower($name));
    }

    /**
     * Returns vertex name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns vertex sequence
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence;
    }
}
