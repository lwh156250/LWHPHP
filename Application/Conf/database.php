<?php
return array(
	'master' => array(
		'type' => 'MySQL',
		'host' => '127.0.0.1',
		'user' => 'root',
		'password' => '',
		'dbname' => 'test'
	),
	'slave' => array(
		'slave1' => array(
			'type' => 'MySQL',
			'host' => '127.0.0.1',
			'user' => 'root',
			'password' => '',
			'dbname' => 'test'
		),
		'slave2' => array(
			'type' => 'MySQL',
			'host' => '127.0.0.1',
			'user' => 'root',
			'password' => '',
			'dbname' => 'test'
		),
	),
);