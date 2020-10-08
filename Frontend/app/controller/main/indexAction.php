<?php

namespace app\controller;
use App;

class indexAction extends baseAction
{
    /**
     * 首页
     */
    public function action_index()
    {
        return $this->display('main/index', array(
        ));
    }

}