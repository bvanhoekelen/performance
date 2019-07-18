<?php

class User extends Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;

    protected $table = 'user';
}

// Table info
//
// CREATE TABLE `user` (
//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `name` varchar(255) DEFAULT NULL,
//  `email` varchar(255) DEFAULT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
