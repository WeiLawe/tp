<?php
 
namespace app\home\validate;
use think\Validate; 

class Repair extends Validate{
    protected $rule = [
        ['name', 'require', '姓名不能为空'],
        ['tel', 'require|length:11|/^1[34578]\d{9}$/', '电话号码不能为空|手机号码必须为11位,请检查!|电话号码不合法'],
        ['address', 'require', '地址不能为空'],
        ['title', 'require', '标题不能为空'],
        ['content', 'require', '内容不能为空'],
    ];
}