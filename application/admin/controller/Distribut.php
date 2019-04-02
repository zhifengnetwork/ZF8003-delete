<?php

/**
 * tpshop
 * 分销设置控制器
 * ----------------------------------------------------------------------
 * Author: pc
 * Date: 2019-04-01
 */

 namespace app\admin\controller;

 use think\Cache;

 /**
  * 分销设置
  */
 class Distribut extends Base
 {
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 分销入口中心
     */
    public function center_entrance()
    {
        return $this->fetch();
    }

    /**
     * 分销商列表
     */
    public function distributor_list()
    {
        return $this->fetch();
    }

    /**
     * 分销商等级
     */
    public function distributor_level()
    {
        return $this->fetch();
    }

    /**
     * 通知设置
     */
    public function notification()
    {
        $data = input('post.');
        if ($data) {
            if (is_array($data)) {
                $result = array_filter($data,function($k){
                    return $k != 'distribut';
                });
    
                $result = json_encode($result);
                tpCache($data['inc_type'],['notic'=>$result]);
                $where = array('name'=>'notic','inc_type'=>$data['inc_type']);
                $is_distribut = M('config')->where($where)->find();
                
                if ($is_distribut) {
                    $is_bool = M('config')->where($where)->update(['value'=>$result]);
                } else {
                    $is_bool = M('config')->insert(['name'=>'notic','value'=>$result,'inc_type'=>$data['inc_type']]);
                }
            }
        }

        $notic = tpCache('distribut.notic');
        $notic = json_decode($notic,true);

        $this->assign('config',$notic);
        return $this->fetch();
    }
 }