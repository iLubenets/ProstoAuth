ProstoAuth
==========

Prosto authentication library

Config
==========
    array (
      'database' => 
      array (
        'connection_string' => 'host=localhost port=5432 dbname=database user=user password=password',
      ),
      'prosto_auth' => 
      array (
        'methods' => 
        array (
          'teammember' => 
          array (
            'class' => 'ProstoAuth\\AuthenticateMethod\\TeamMemberAuthenticateMethod',
            'vpn_ip_mask' => '/^127.0.0.([0-9]{1,3})$/',
          ),
        ),
      ),
    )
