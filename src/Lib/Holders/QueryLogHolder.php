<?php

declare(strict_types=1);

namespace Performance\Lib\Holders;

/**
 * Class QueryLogHolder
 * @package Performance\Lib\Holders
 */
class QueryLogHolder
{
    /**
     * @var
     */
    public $queryType;

    /**
     * @var null
     */
    public $query;

    /**
     * @var array
     */
    public $bindings;

    /**
     * @var null
     */
    public $time;

    /**
     * @var
     */
    public $driver;

    /**
     * @var
     */
    public $database;

    /**
     * @var
     */
    public $host;

    /**
     * @var
     */
    public $port;

    /**
     * @var
     */
    public $username;

    /**
     * @var
     */
    public $prefix;

    /**
     * @var array
     */
    public $connectionName;

    /**
     * QueryLogHolder constructor.
     * @param $sql
     */
    public function __construct($sql)
    {
        $this->time = isset($sql->time) ? $sql->time : null;
        $this->query = isset($sql->sql) ? $sql->sql : null;
        $this->bindings = isset($sql->bindings) ? $sql->bindings : [];

        $connection = $sql->connection;

// null fix change https://github.com/illuminate/database/commit/ba465fbda006d70265362012653b4e97667c867b#diff-eba180ff89e23df156c82c995be952df
        $config = method_exists($connection, 'getConfig') ? $sql->connection->getConfig(null) : [];

        $this->connectionName = method_exists($connection, 'getName') ? $sql->connection->getName() : [];
        $this->setUpConnection($connection, $config);

        // Check type
        $this->checkQueryType();
    }

    /**
     * Set query type
     */
    protected function checkQueryType()
    {
        if (strtolower(substr($this->query, 0, 6)) === 'select') {
            $this->queryType = 'select';
        } elseif (strtolower(substr($this->query, 0, 6)) === 'insert') {
            $this->queryType = 'insert';
        } elseif (strtolower(substr($this->query, 0, 6)) === 'delete') {
            $this->queryType = 'delete';
        } elseif (strtolower(substr($this->query, 0, 6)) === 'update') {
            $this->queryType = 'update';
        } else {
            $this->queryType = 'unknown';
        }
    }

    /**
     * @param $connection
     * @param array $config
     */
    public function setUpConnection($connection, array $config): void
    {
        if (method_exists($connection, 'getConfig')) {
            $this->database = isset($config[ 'database' ]) ? $config[ 'database' ] : null;
            $this->driver = isset($config[ 'driver' ]) ? $config[ 'driver' ] : null;
            $this->host = isset($config[ 'host' ]) ? $config[ 'host' ] : null;
            $this->port = isset($config[ 'port' ]) ? $config[ 'port' ] : null;
            $this->username = isset($config[ 'username' ]) ? $config[ 'username' ] : null;
            $this->prefix = isset($config[ 'prefix' ]) ? $config[ 'prefix' ] : null;
        }
    }
}
