<?php
namespace app\admin\controller;

/*
 * 在线报修管理
 */

use think\Db;
use think\Request;

class Repair extends Admin{
    /*
     * 在线报修列表
     */
    public function index(){
        $list=Db::name('Repair')->order('id asc')->paginate(3);
//        var_dump($list);die;

//        dump($list);die;
        $this->assign('list',$list);
        $this->assign('meta_title' , '在线报修');
        return $this->fetch();
    }

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
                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_repair', 'repair', $data->id, UID);
            } else {
                $this->error($repair->getError());
            }
        }else{
            return $this->fetch('add');
        }
    }

    /*
     * 修改在线报修
     */
    public function edit($id)
    {
        if($this->request->isPost()){
            $repair=model('repair');
            $post_data=Request::instance()->post();
            //验证信息
            $validate = validate('repair');
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            $data = $repair->update($post_data);
            if($data !== false){
                $this->success('修改成功', url('index'));
            } else {
                $this->error('修改失败');
            }
        }else{
            $info=Db::name('Repair')->find($id);
//            dump($info);
            $this->assign('info', $info);
            return $this->fetch();
        }
    }

    /*
     * 删除在线报修
     */
    public function del()
    {
        $id = array_unique((array)input('id/a',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(\think\Db::name('repair')->where($map)->delete()){
            //记录行为
            action_log('update_repair', 'repair', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}