<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aa
 * Date: 29.04.13
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 */

namespace ProstoAuth\Exception;


class DatabaseWrongQueryException extends DatabaseException
{
    /**
     * @var string
     */
    private $query;

    /**
     * @param string     $message
     * @param int        $code
     * @param string     $query
     * @param \Exception $previous
     */
    public function __construct($message, $code, $query, \Exception $previous = null)
    {
        $this->query = $query;
        parent::__construct( $message, $code, $previous );
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

}
