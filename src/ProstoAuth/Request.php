<?php
/**
 * Created by PhpStorm.
 * User: il
 * Date: 12/12/13
 * Time: 2:18 PM
 */

namespace ProstoAuth;


class Request
{
    private $request;
    private $query;

    private $method;
    private $statusCode;
    private $queryString;
    private $uri;
    private $clientIp;

    function __construct()
    {
        $this->query = $_GET;
        $this->request = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->statusCode = $_SERVER['REDIRECT_STATUS'];
        $this->queryString = $_SERVER['QUERY_STRING'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->clientIp = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return mixed
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get variable from POST/GET array
     * @param $variableName
     * @return null
     */
    public function has($variableName)
    {
        if (array_key_exists($variableName, $this->request)) {
            return true;
        } elseif (array_key_exists($variableName, $this->query)) {
            return true;
        }

        return false;
    }

    /**
     * Get variable from POST/GET array
     * @param $variableName
     * @return null
     */
    public function get($variableName)
    {
        if (array_key_exists($variableName, $this->request)) {
            return $this->request[$variableName];
        }

        if (array_key_exists($variableName, $this->query)) {
            return $this->query[$variableName];
        }

        return null;
    }
}