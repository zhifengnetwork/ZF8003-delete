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
 use think\Page;
 use think\Loader;

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
     * 分销商等级列表
     */
    public function distributor_level()
    {
        $level_list = M('distribut_level');
        $p = $this->request->param('p');
        $res = $level_list->order('level_id')->page($p . ',10')->select();
        if ($res) {
            foreach ($res as $val) {
                $list[] = $val;
            }
        }
        $this->assign('list', $list);
        $count = $level_list->count();
        $Page = new Page($count, 10);
        $show = $Page->show();
        $this->assign('page', $show);
        return $this->fetch();
    }

    /**
     * 等级设置
     */
    public function level()
    {
        $act = I('get.act', 'add');
        $this->assign('act', $act);
        $level_id = I('get.level_id');
        if ($level_id) {
            $level_info = D('distribut_level')->where('level_id=' . $level_id)->find();
            $this->assign('info', $level_info);
        }
        return $this->fetch();
    }

    public function handle_level()
    {
        $data = I('post.');
        $DistributValidate = Loader::validate('Distribut');
        $return = ['status' => 0, 'msg' => '参数错误', 'result' => ''];//初始化返回信息

        if ($data['act'] == 'add') {
            if (!$DistributValidate->batch()->check($data)) {
                $return = ['status' => 0, 'msg' => '添加失败', 'result' => $DistributValidate->getError()];
            } else {
                $bool = D('distribut_level')->add($data);
                if ($bool !== false) {
                    $return = ['status' => 1, 'msg' => '添加成功', 'result' => $DistributValidate->getError()];
                } else {
                    $return = ['status' => 0, 'msg' => '添加失败', 'result' => ''];
                }
            }
        }
        
        $this->ajaxReturn($return);
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