<?php

return [

	/*
	|--------------------------------------------------------------------------
	| IP Whitelist Range
	|--------------------------------------------------------------------------
	|
	| Internal DJ Components should be accessible to certain IP Ranges
	| without requiring the user to authenticate first
	|
	*/

	'whitelist' => [
		'start' => env('WHITELIST_START', '127.0.0.1'),
		'end' => env('WHITELIST_END', '127.0.0.1')
	],

	'icecast' => [
		'hostname' => env('ICECAST_HOSTNAME'),

		'credentials' => [
			env('ICECAST_USERNAME'),
			env('ICECAST_PASSWORD'),
		],

		'mounts' => [
			'studio-x' => [
				'witr-mp3-192',
				'witr-mp3-80',
				'witr-mobile',
			],
			'studio-a' => [
				'witr-undrgnd-mp3-192',
				'witr-undrgnd-mobile',
			]
		]
	]

];