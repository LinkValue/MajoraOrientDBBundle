<?php

namespace Majora\Component\Graph\Engine;

use Doctrine\Common\Collections\ArrayCollection;
use Majora\Component\Graph\Engine\OrientDbMetadata;
use Majora\Component\Graph\Vertex\Vertex;

/**
 * OrientDB engine class
 */
class OrientDbEngine
{
    /**
     * @var ArrayCollection
     */
    protected $configurations;

    /**
     * @var ArrayCollection
     */
    protected $databases;

    /**
     * @var ArrayCollection
     */
    protected $connections;

    /**
     * construct
     */
    public function __construct()
    {
        $this->configurations = new ArrayCollection();
        $this->databases = new ArrayCollection();
        $this->connections = new ArrayCollection();
    }

    /**
     * Register a new OrientDB connection under given name
     *
     * @param string $name
     */
    public function registerConnection($name, array $configuration)
    {
        $this->configurations->set($name, new OrientDbMetadata(
            $configuration['host'],
            $configuration['port'],
            $configuration['timeout'],
            $configuration['user'],
            $configuration['password'],
            $configuration['database'],
            $configuration['data_type'],
            $configuration['storage_type']
        ));
    }

    /**
     * Register new vertex to given configuration name
     *
     * @param string $connectionName
     * @param string $vertex
     */
    public function registerVertex($connectionName, $vertex)
    {
        $this->getConfiguration($connectionName)->registerVertex(new Vertex($vertex));
    }

    /**
     * Return registered configuration under given connectionName
     *
     * @param string $connectionName
     *
     * @return OrientDbMetadata
     */
    public function getConfiguration($connectionName = 'default')
    {
        if (!$this->configurations->containsKey($connectionName)) {
            throw new \InvalidArgumentException(sprintf('Any registered configuration under given key.'));
        }

        return $this->configurations->get($connectionName);
    }

    /**
     * Return registered connection under given connectionName
     *
     * @param string $connectionName
     *
     * @return \OrientDB
     */
    public function getConnection($connectionName = 'default')
    {
        if ($this->connections->containsKey($connectionName)) {
            return $this->connections->get($connectionName);
        }

        $configuration = $this->getConfiguration($connectionName);

        $this->connections->set($connectionName,
            $database = (new \OrientDB(
                $configuration->getHost(),
                $configuration->getPort(),
                $configuration->getTimeout()
            ))
        );
        $database->connect(
            $configuration->getUser(),
            $configuration->getPassword()
        );

        return $database;
    }

    /**
     * Tries to create a database for given connection name
     *
     * @param string $name
     *
     * @return \OrientDB
     */
    public function createDatabase($connectionName)
    {
        $configuration = $this->getConfiguration($connectionName);
        $database = $this->getConnection($connectionName);

        $database->DBCreate(
            $configuration->getDatabase(),
            $configuration->getDataType(),
            $configuration->getStorageType()
        );

        return $this->getDatabase($connectionName);
    }

    /**
     * Tries to drop a database for given connection name
     *
     * @param string $name
     *
     * @return \OrientDB
     */
    public function dropDatabase($connectionName)
    {
        $configuration = $this->getConfiguration($connectionName);
        $database = $this->getConnection($connectionName);

        $database->DBDelete(
            $configuration->getDatabase()
        );
    }

    /**
     * Return registered database under given name
     *
     * @param string $connectionName
     *
     * @return \OrientDB
     */
    public function getDatabase($connectionName = 'default')
    {
        if ($this->databases->containsKey($connectionName)) {
            return $this->databases->get($connectionName);
        }

        $configuration = $this->getConfiguration($connectionName);
        $database = $this->getConnection($connectionName);

        $database->DBOpen(
            $configuration->getDatabase(),
            $configuration->getUser(),
            $configuration->getPassword()
        );

        $this->databases->set($connectionName, $database);

        return $this->databases->get($connectionName);
    }

    /**
     * Synchronize vertexes and edges with related OrientDb database
     *
     * @param string $connectionName
     */
    public function synchronize($connectionName)
    {
        $configuration = $this->getConfiguration($connectionName);
        $database = $this->getDatabase($connectionName);

        foreach ($configuration->getVertexes() as $vertex) {
            try {
                $database->query(sprintf('CREATE CLASS %s EXTENDS V',
                    $vertex->getName()
                ));
                $database->query(sprintf('DISPLAY RECORD 0',
                    $vertex->getName()
                ));
                dump($res); die;
            } catch (\Exception $e) {
                if (preg_match(sprintf('/Class %s already exists in current database$/', $vertex->getName()), $e->getMessage())) {
                    continue;
                }

                throw $e;
            }
        }
    }
}
