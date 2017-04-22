<?php namespace Performance\Lib;

class QueryLogHolder
{
    public $queryType;
    public $time;
    public $query;
    public $databaseName;
    public $driverName;
    public $bindings;
    public $config;

    /*
     * Create holder object
     */
    function __construct($sql)
    {
        $connection = $sql->connection;

        $this->time = isset($sql->time) ? $sql->time : null;
        $this->query = isset($sql->sql) ? $sql->sql : null;
        $this->bindings = isset($sql->bindings) ? $sql->bindings : [];
        $this->databaseName = method_exists($connection, 'getDatabaseName') ? $sql->connection->getDatabaseName() : null;
        $this->driverName = method_exists($connection, 'getDriverName') ? $sql->connection->getDriverName() : null;
        $this->config = method_exists($connection, 'getConfig') ? $sql->connection->getConfig() : null;

        // Remove password
        unset($this->config['password']);

        // Check type
        $this->checkQueryType();
    }

    /*
     * Set query type
     */
    private function checkQueryType()
    {
        if(substr($this->query, 0, 6) == 'select')
            $this->queryType = 'select';
        elseif(substr($this->query, 0, 6) == 'insert')
            $this->queryType = 'insert';
        elseif(substr($this->query, 0, 6) == 'delete')
            $this->queryType = 'delete';
        else
            $this->queryType = 'unknown';
    }
}