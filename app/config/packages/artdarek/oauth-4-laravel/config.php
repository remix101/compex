<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '935257216562474',
            'client_secret' => '6a0539b1c59fdae7840a517a554b943d',
            'scope'         => array('email','user_friends'),
        ),		

		/**
		 * Google
		 */
        'Google' => array(
            'client_id'     => '18202384714-i9o9b8qraehtbc08bq8ci3mokrn1nbmb.apps.googleusercontent.com',
            'client_secret' => 'LZGpngKDgxyrJxmsEfOZSwvR',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),

		/**
		 * LinkedIn
		 */
        'LinkedIn' => array(
            'client_id'     => '77vvuv9935tl64',
            'client_secret' => 'YHRGmM4bJM8LsVOn',
        ),		

		/**
		 * Yahoo
		 */
        'Yahoo' => array(
            'client_id'     => 'dj0yJmk9YXRsWGpDZllzbldtJmQ9WVdrOVJ6QnZjblo1TjJrbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1mNg--',
            'client_secret' => '8365295aa5191ba4a64ef22647e0aee55ca85f82',
        ),		

	)

);