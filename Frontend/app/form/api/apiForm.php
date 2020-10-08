<?
namespace app\form;
use biny\lib\Form;


class apiForm extends Form
{
    protected $_rules = [
        'token'=>[self::typeNonEmpty],
    ];

}