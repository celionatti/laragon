<?php

namespace models;

use Core\Database\DbModel;

class Users extends DbModel
{
    public static function tableName(): string
    {
        return 'users';
    }
}