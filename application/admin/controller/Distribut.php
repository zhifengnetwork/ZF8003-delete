<?php

/**
 * tpshop
 * 分销设置控制器
 * ----------------------------------------------------------------------
 * Author: pc
 * Date: 2019-04-01
 */

 namespace app\admin\controller;

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
        return $this->fetch();
    }
 }