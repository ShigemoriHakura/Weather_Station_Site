<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class userAction extends baseAction
{
    /**
     * 用户
     */
    public function action_index()
    {
        if (!App::$model->user->exist()){
            $this->response->redirect('/login');
        }
        $userData = App::$model->user->values();
        $tokenData = $this->tokenDAO->filter([
            'userid'=>$userData['id'],
        ])->order(array('id'=>'ASC'))->query();
        return $this->display('user/token', array(
            'tokenData' => $tokenData,
        ));
    }

    public function action_setToken()
    {
        if (!App::$model->user->exist()){
            $this->response->redirect('/login');
        }
        $form = $this->getForm('add');
        if (!$form->check()){
            //$error = $form->getError();
            return $this->display('token/add', array(
                'status' => false
            ));
        }else {
            $userData = App::$model->user->values();
            $tokenDataCount = $this->tokenDAO->filter([
                'userid'=>$userData['id'],
            ])->count();
            if($tokenDataCount >= 10){
                return $this->display('token/add', array(
                    'status' => false
                ));
            }
            $sets = array(
                'userid'    => $userData['id'],
                'add_date'  => time(),
                'up_date'   => time(),
                'last_use_date'  => 0,
                'token'     => $this->rand(8),
                'note'      => $form->note,
                'city'      => $form->city,
                'enabled'   => 1,
            );
            // false 时返回true/false
            $status = $this->tokenDAO->add($sets, false);
            return $this->display('token/add', array(
                'status' => $status
            ));
        }
    }

    function rand($len)
    {
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $string=time();
        for(;$len>=1;$len--)
        {
            $position=rand()%strlen($chars);
            $position2=rand()%strlen($string);
            $string=substr_replace($string,substr($chars,$position,1),$position2,0);
        }
        return $string;
    }

    public function action_modifyToken()
    {

    }

    public function action_getToken()
    {

    }

    public function action_deleteToken()
    {

    }

    public function action_login()
    {
        if (App::$model->user->exist()){
            $this->response->redirect('/');
        }
        $form = $this->getForm('login');
        if (!$form->check()){
            // 获取错误信息
            $error = $form->getError();
            return $this->display('user/login' , array(
                "message" => $error,
            ));
        }else{
            if ($user = $this->userDAO->filter(['username'=>$form->username])->find()){
                if($user['password'] == md5(sha1(md5($form->password)))){
                    App::$model->user($user['id'])->login($user['id']);
                }else{
                    return $this->display('user/login' , array(
                        "message" => "X",
                    ));
                }
            } else {
                return $this->display('user/login' , array(
                    "message" => "X",
                ));
            }
            if ($lastUrl = App::$base->session->lastUrl){
                unset(App::$base->session->lastUrl);
                $this->response->redirect($lastUrl);
            } else {
                $this->response->redirect('/');
            }
        }
    }

    public function action_register()
    {
        if (App::$model->user->exist()){
            $this->response->redirect('/');
        }
        $form = $this->getForm('register');
        if (!$form->check()){
            $error = $form->getError();
            return $this->display('user/register' , array(
                "message" => $error,
            ));
        }else{
            if ($user = $this->userDAO->filter(['username'=>$form->username])->find()) {
                return $this->display('user/register' , array(
                    "message" => "Register_Isset",
                ));
            }else{
                $pass = md5(sha1(md5($form->password)));
                $sets = array(
                    'level'     => 0,
                    'username'  => $form->username,
                    'password'  => $pass,
                    'email'     => $form->email,
                    'add_date'  => time(),
                    'last_login_date'  => 0,
                    'verifyCode' => 0,
                    'enabled'    => 1
                );
                // false 时返回true/false
                $status = $this->userDAO->add($sets, false);
                return $this->display('user/register', array(
                    'status' => $status
                ));
            }
        }
    }

    public function action_logout()
    {
        if (App::$model->user->exist()){
            App::$model->user->loginOut();
        }
        if ($lastUrl = App::$base->session->lastUrl){
            unset(App::$base->session->lastUrl);
            $this->response->redirect($lastUrl);
        } else {
            $this->response->redirect('/');
        }
    }

}