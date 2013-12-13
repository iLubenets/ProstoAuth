<?php
namespace ProstoAuth\Database;

use ProstoAuth\Exception\DatabaseConnectException;
use ProstoAuth\Exception\DatabaseWrongQueryException;

class PgDatabase
{
    private $connectionString;
    private $internalConnection = null;

    public function __construct($connectionString)
    {
        $this->connectionString = $connectionString;
    }

    /**
     * Check connect
     * @throws \ProstoAuth\Exception\DatabaseConnectException
     * @return bool
     */
    public function checkConnection()
    {
        $connection = $this->getConnection();
        if(!$connection){
            throw new DatabaseConnectException('Connection is not established.');
        }
    }

    private function getConnection()
    {
        if (is_null($this->internalConnection)) {
            try {
                $this->internalConnection = pg_connect($this->connectionString);
                if (!$this->internalConnection) {
                    throw new DatabaseConnectException(sprintf('%s: Error database connection pg_connect()', __METHOD__));
                }
            } catch (\Exception $e) {
                throw new DatabaseConnectException($e->getMessage());
            }
            // Set date style format
            pg_query($this->internalConnection, 'SET datestyle TO German;');
        }

        return $this->internalConnection;

    }

    public function getQueryResult($query)
    {
        return $this->getQueryResultAsync($query);
    }

    private function getQueryResultAsync($query)
    {
        $connection = $this->getConnection();

        // @todo: check connection is busy
        // pg_connection_busy( $connection )
        $queryResult = pg_send_query($connection, $query);

        if (!$queryResult) {
            throw new DatabaseWrongQueryException(sprintf('%s: QUERY:"%s"', 0, $query), 0, $query);
        }

        $resource = pg_get_result($connection);
        $error = pg_result_error($resource);

        if ($error) {
            $message = pg_result_error_field($resource, PGSQL_DIAG_MESSAGE_PRIMARY);
            throw new DatabaseWrongQueryException($message . ': ' . $query, 0, $query);
        }

        $queryData = pg_fetch_all($resource);
        if ($queryData === false) {
            // FALSE is returned if there are no rows in the result, or on any other error.
            return array();
        }

        return $queryData;
    }

    public function escape_string($data)
    {
        return pg_escape_string($this->getConnection(), $data);
    }

    public function getConnectionIdentifier()
    {
        return (string)$this->internalConnection;
    }

}
