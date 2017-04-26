<?php namespace Performance\Lib\Holders;

class QueryLogHolder
{
    public $queryType;
    public $query;
    public $bindings;
    public $time;
    public $driver;
    public $database;
    public $host;
    public $port;
    public $username;
    public $prefix;
    public $connectionName;

    /*
     * Create holder object
     */
    function __construct($sql)
    {
        $this->time = isset($sql->time) ? $sql->time : null;
        $this->query = isset($sql->sql) ? $sql->sql : null;
        $this->bindings = isset($sql->bindings) ? $sql->bindings : [];

        $connection = $sql->connection;
        $config = method_exists($connection, 'getConfig') ? $sql->connection->getConfig() : [];
        $this->connectionName = method_exists($connection, 'getName') ? $sql->connection->getName() : [];
        if (method_exists($connection, 'getConfig')) {
            $this->database = isset($config['database']) ? $config['database'] : null;
            $this->driver = isset($config['driver']) ? $config['driver'] : null;
            $this->host = isset($config['host']) ? $config['host'] : null;
            $this->port = isset($config['port']) ? $config['port'] : null;
            $this->username = isset($config['username']) ? $config['username'] : null;
            $this->prefix = isset($config['prefix']) ? $config['prefix'] : null;
        }

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
        elseif(substr($this->query, 0, 6) == 'update')
            $this->queryType = 'update';
        else
            $this->queryType = 'unknown';
    }
}