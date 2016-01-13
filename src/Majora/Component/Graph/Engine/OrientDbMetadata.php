<?php

namespace Majora\Component\Graph\Engine;

use Doctrine\Common\Collections\ArrayCollection;
use Majora\Component\Graph\Vertex\Vertex;

/**
 * Metadata value object for OrientDb configurations
 */
class OrientDbMetadata
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $storageType;

    /**
     * @var string
     */
    protected $dataType;

    /**
     * @var ArrayCollection
     */
    protected $vertexes;

    /**
     * construct
     *
     * @param string $host
     * @param string $port
     * @param string $timeout
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $type
     */
    public function __construct($host, $port, $timeout, $user, $password, $database, $dataType, $storageType)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->dataType = $dataType;
        $this->storageType = $storageType;
        $this->vertexes = new ArrayCollection();
    }

    /**
     * return metadata host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * return metadata port
     *
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * return metadata timeout
     *
     * @return string
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * return metadata user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * return metadata password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * return metadata database
     *
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * return metadata storageType
     *
     * @return string
     */
    public function getStorageType()
    {
        return $this->storageType;
    }

    /**
     * return metadata dataType
     *
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Returns configured vertexes
     *
     * @return ArrayCollection
     */
    public function getVertexes()
    {
        return $this->vertexes;
    }

    /**
     * register a new vertex into metadata
     *
     * @param Vertex $vertex
     *
     * @return OrientDbMetadata
     */
    public function registerVertex(Vertex $vertex)
    {
        $this->vertexes->set($vertex->getName(), $vertex);

        return $this;
    }
}
