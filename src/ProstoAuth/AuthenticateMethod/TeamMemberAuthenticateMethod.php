<?php
/**
 * Created by PhpStorm.
 * User: il
 * Date: 12/12/13
 * Time: 3:02 PM
 */

namespace ProstoAuth\AuthenticateMethod;


use ProstoAuth\Database\PgDatabase;
use ProstoAuth\Provider\TeamMemberProvider;
use ProstoAuth\Request;
use ProstoAuth\User\UserInterface;

class TeamMemberAuthenticateMethod implements AuthenticateMethodInterface
{
    /**
     * Return user object.
     *
     * @param \ProstoAuth\Database\PgDatabase $connection
     * @param array $config
     * @param \ProstoAuth\Request $request
     * @return UserInterface|null
     */
    public function getUser(PgDatabase $connection, $config, Request $request)
    {
        $provider = new TeamMemberProvider($connection);
        $user = $provider->loadUserByIdentifier($request->getClientIp());

        return $user;
    }

    /**
     * Checks the user account after authentication.
     *
     * @param UserInterface $user a UserInterface instance
     */
    public function checkPostAuth(UserInterface $user)
    {
        return $user->getIsEnabled();
    }
}