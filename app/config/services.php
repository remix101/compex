<?php

return array(

    /*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

    'mailgun' => array(
        'domain' => 'ng.cx',
        'secret' => 'key-44yuwzjc920rdahdig2p3p0s3ohnah75',
    ),

    'mandrill' => array(
        'secret' => '',
    ),

    'stripe' => array(
        'model'  => 'User',
        'secret' => '',
    ),
    /**
		 * Facebook
		 */
    'Facebook' => array(
        'client_id'     => '935257216562474',
        'client_secret' => '6a0539b1c59fdae7840a517a554b943d',
        'scope'         => array('user'),
    ),		

    /**
		 * Google
		 */
    'Google' => array(
        'client_id'     => '18202384714-i9o9b8qraehtbc08bq8ci3mokrn1nbmb.apps.googleusercontent.com',
        'client_secret' => 'LZGpngKDgxyrJxmsEfOZSwvR',
        'scope'         => array('userinfo'),
    ),

    /**
		 * LinkedIn
		 */
    'LinkedIn' => array(
        'client_id'     => '77vvuv9935tl64',
        'client_secret' => 'YHRGmM4bJM8LsVOn',
        'scope'         => array(),
    ),		

    /**
		 * Yahoo
		 */
    'Yahoo' => array(
        'client_id'     => 'dj0yJmk9ZHRheUtwMGJNWUxqJmQ9WVdrOWRuaFVjV1owTTJNbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1jNQ--',
        'client_secret' => 'f0e373d0b85717bc6bdc462056b32573d566881c',
        'scope'         => array(),
    ),		


);
