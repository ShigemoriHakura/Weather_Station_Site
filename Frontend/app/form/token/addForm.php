<?
namespace app\form;
use biny\lib\Form;


class addForm extends Form
{
    protected $_rules = [
        'note'=>[self::typeNonEmpty],
        'city'=>[self::typeNonEmpty],
    ];

}