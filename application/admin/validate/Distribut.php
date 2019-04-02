<?php
namespace app\admin\validate;
use think\Validate;
class Distribut extends Validate
{
    // 验证规则
    protected $rule = [
        ['level_name', 'require|unique:distribut_level'],
        ['level', 'require|number|unique:distribut_level'],
        ['rate1', 'require|between:0,100'],
        ['order_money', 'require|'],
    ];
    //错误信息
    protected $message  = [
        'level_name.require'    => '名称必填',
        'level_name.unique'     => '已存在相同等级名称',
        'level.require'         => '等级级别必填',
        'level.unique'          => '已存在相同等级级别',
        'level.number'          => '级别必须是数字',
        'rate1.require'         => '佣金比率必填',
        'rate1.between'         => '佣金比率在0-100之间',
        'order_money.require'   => '升级条件必填',
        'order_money.number'    => '升级条件必须是数字',
    ];
    //验证场景
    protected $scene = [
        'edit'  =>  [
            'level_name'    =>'require|unique:distribut_level,level_name^level_id',
            'level'         =>'require|number|unique:distribut_level,level^level_id',
            'rate1'         =>'require|between:0,100',
            'order_money'   =>'require|number',
        ],
    ];
}