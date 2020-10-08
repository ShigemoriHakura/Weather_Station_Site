<?php

namespace app\dao;

/**
 * 天气数据表
 */
class weatherBaseDAO extends baseDAO
{
    protected $table = 'weather_city_base';
    protected $_pk = 'id';
    protected $_pkCache = true;
}