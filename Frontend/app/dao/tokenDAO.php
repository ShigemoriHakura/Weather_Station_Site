<?php

namespace app\dao;

/**
 * token表
 */
class tokenDAO extends baseDAO
{
    protected $table = 'weather_users_token';
    protected $_pk = 'id';
    protected $_pkCache = true;
}