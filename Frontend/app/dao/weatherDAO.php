<?php

namespace app\dao;

/**
 * 天气数据表
 */
class weatherDAO extends baseDAO
{
    protected $table = 'weather_city_data';
    protected $_pk = 'id';
    protected $_pkCache = true;
}