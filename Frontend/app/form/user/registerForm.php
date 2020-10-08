<?
namespace app\form;
use biny\lib\Form;


class registerForm extends Form
{
    protected $_rules = [
        'email'=>['checkEmail'],
        'username'=>[self::typeNonEmpty],
        'password'=>[self::typeNonEmpty],
    ];

    public function valid_checkEmail()
    {
        $result = trim($this->email);//trim方法去除首位的空格
        if (filter_var($result, FILTER_VALIDATE_EMAIL)) {
            return $this->correct();
        } else {
            return $this->error('Email_Error');
        }
    }

}