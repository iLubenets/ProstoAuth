<?php
/**
 * Created by PhpStorm.
 * User: il
 * Date: 12/13/13
 * Time: 10:40 AM
 */

namespace ProstoAuth;


use ProstoAuth\Checker\AuthenticateMethodInterface;
use ProstoAuth\Database\PgDatabase;
use ProstoAuth\Exception\ProstoAuthException;

class ProstoAuth
{
    private $config;
    private $methods;
    private $connection;
    private $request;

    function __construct($config)
    {
        $this->config = $config;
        $this->setMethods($config);
        $this->setConnection($config);
        $this->request = new Request();
    }

    private function setConnection($config)
    {
        // Check required parameters "methods"
        if(!isset($config['database']['connection_string'])){
            throw new ProstoAuthException(sprintf('%s: "database.connection_string" not found in config.', __METHOD__));
        }
        $this->connection = new PgDatabase($config['database']['connection_string']);
    }

    private function setMethods($config)
    {
        // Check required parameters "methods"
        if(!isset($config['methods'])){
            throw new ProstoAuthException(sprintf('%s: "methods" not found in config.', __METHOD__));
        }
        // Check required parameter class in each method
        foreach($this->methods as $methodName => $methodDefinition){
            if(!isset($method['class'])){
                throw new ProstoAuthException(sprintf('%s: "class" not found in method "%s"', __METHOD__, $methodName));
            }
        }
        $this->methods = $config['methods'];
    }

    public function getAuthenticateUser($authMethod)
    {
        if(!$this->methods[$authMethod]){
            throw new ProstoAuthException(sprintf('%s: method "%s" not found in config.', __METHOD__, $authMethod));
        }
        if(!class_exists($this->methods[$authMethod]['class'])){
            throw new ProstoAuthException(sprintf('%s: class "%s" not found.', __METHOD__, $this->methods[$authMethod]['class']));
        }
        $authenticateMethodClass = $this->methods[$authMethod]['class'];
        /** @var AuthenticateMethodInterface $authenticateMethod */
        $authenticateMethod = new $authenticateMethodClass;
        $user = $authenticateMethod->getUser($this->connection, $this->methods[$authMethod], $this->request);
        if($user === null || !$authenticateMethod->checkPostAuth($user)){
            return null;
        }

        return $user;
    }

} 