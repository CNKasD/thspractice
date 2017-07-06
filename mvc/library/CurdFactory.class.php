<?php
// require 'Mysql.class.php';

class CurdFactory
{
    public static function createCurd($type, $table)
    {
        switch ($type) {
            case 'mysql':
                return new Mysql($table);
            case 'mongo':
            	return new MyMongo($table);
        }
    }
}