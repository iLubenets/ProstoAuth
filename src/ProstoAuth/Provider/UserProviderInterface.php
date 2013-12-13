<?php

namespace ProstoAuth\Provider;

use ProstoAuth\User\UserInterface;

/**
 * @author il
 */
interface UserProviderInterface
{
    /**
     * Loads the user for the given identifier.
     *
     * @param string $identifier The user identifier
     *
     * @return UserInterface
     */
    public function loadUserByIdentifier($identifier);


    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    public function supportsClass($class);
}
