<?php
/**
 * Created by PhpStorm.
 * User: il
 * Date: 12/12/13
 * Time: 2:01 PM
 */

namespace ProstoAuth\User;


class TeamMember implements UserInterface
{
    private $id;
    private $name;
    private $password;
    private $ip;
    private $role;
    private $isEnabled;

    function __construct($id, $ip, $name, $password, $role, $isEnabled)
    {
        $this->id = $id;
        $this->ip = $ip;
        $this->isEnabled = $isEnabled;
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof self) {
            return false;
        }

        return true;
    }

} 