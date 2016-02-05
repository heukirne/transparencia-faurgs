<?php

return [

	'google' => [
		'client_id' => env('GOOGLE_OAUTH_ID'),
		'client_secret' => env('GOOGLE_OAUTH_SECRET'),
		'redirect' => env('GOOGLE_OAUTH_REDIRECT'),
	],

	'facebook' => [
		'client_id' => env('FACEBOOK_OAUTH_ID'),
		'client_secret' => env('FACEBOOK_OAUTH_SECRET'),
		'redirect' => env('FACEBOOK_OAUTH_REDIRECT'),
	],

];