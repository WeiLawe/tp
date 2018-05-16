<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 下午 4:03
 */
namespace app\Home\controller;
use app\home\controller\Home;
use think\Request;

class Repair extends Home{

    /*
     * 添加在线报修
     */
    public function add()
    {
        if (request()->isPost()){
//            echo '<pre>';
//            var_dump(Request::instance()->post());die;
            $repair=model('repair');
            $post_data=Request::instance()->post();
            //验证信息
            $validate = validate('repair');
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
//            dump(date('Y-m-d H:i:s',1526193715));die();
            $data=$repair->create($post_data);
//            dump($data);die;
            if($data){
                $this->success('新增成功', url('/'));
                //记录行为
                action_log('update_repair', 'repair', $data->id, UID);
            } else {
                $this->error($repair->getError());
            }
        }else{
            return $this->fetch('online');
        }
    }
}