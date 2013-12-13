<?php

namespace ProstoAuth\AuthenticateMethod;

use ProstoAuth\Database\PgDatabase;
use ProstoAuth\Request;
use ProstoAuth\User\UserInterface;

/**
 * UserCheckerInterface checks user account when authentication occurs.
 *
 * @author il
 */
interface AuthenticateMethodInterface
{
    /**
     * Return user object.
     *
     * @param \ProstoAuth\Database\PgDatabase $connection
     * @param array $config
     * @param \ProstoAuth\Request $request
     * @return UserInterface|null
     */
    public function getUser(PgDatabase $connection, $config, Request $request);

    /**
     * Checks the user account after authentication.
     *
     * @param UserInterface $user a UserInterface instance
     */
    public function checkPostAuth(UserInterface $user);
}
