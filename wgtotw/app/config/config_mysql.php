<?php

return [
    // Set up details on how to connect to the database

    'dsn'     => "mysql:host=localhost;dbname=wgtotw;",
    'username'        => "root",
    'password'        => "",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "",
/*
	  'dsn'             => "mysql:host=blu-ray.student.bth.se;dbname=pesu12;",
    'username'        => "pesu12",
    'password'        => "qV2=,5lT",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "",
*/

    // Display details on what happens
    'verbose' => true,

    // Throw a more verbose exception when failing to connect
    //'debug_connect' => 'true',
];
