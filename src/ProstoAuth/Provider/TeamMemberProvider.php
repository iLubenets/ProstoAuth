<?php
/**
 * Created by PhpStorm.
 * User: il
 * Date: 12/12/13
 * Time: 2:45 PM
 */

namespace ProstoAuth\Provider;

use ProstoAuth\Database\PgDatabase;
use ProstoAuth\User\TeamMember;
use ProstoAuth\User\UserInterface;

class TeamMemberProvider implements UserProviderInterface
{
    /** @var  PgDatabase */
    private $connection;

    public function __construct(PgDatabase $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Loads the user for the given identifier.
     *
     * @param string $identifier The user identifier
     *
     * @return UserInterface|null
     */
    public function loadUserByIdentifier($identifier)
    {
        $sql = sprintf('SELECT * FROM it.teammember_ipaddress WHERE ip = \'%s\'',
            $this->connection->escape_string($identifier)
        );
        $result = $this->connection->getQueryResult($sql);

        if(isset($result[0])){
            $userData = $result[0];
            return new TeamMember($userData['id'], $userData['ip'], $userData['username'], null,
                array(), true);
        }
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    public function supportsClass($class)
    {
        return in_array(
            $class,
            array(
                'ProstoAuth\User\TeamMember',
            )
        );
    }
}