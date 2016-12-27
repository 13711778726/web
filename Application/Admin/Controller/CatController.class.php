<?php
namespace Admin\Controller;
use Think\Controller;
class CatController extends Controller {
    //分类模板
    public function catlist() {
        $this->display();
    }
    //分类数据加载
    public function catAjax(){
        $arr = [];
        $where = ['isdel'=>0];
        $Cat = M('cat');
        $count = $Cat->count();
        $page = I('request.page',1,'int');
        $name = I('request.name','','string');
        if(!empty($name)){
            $where['name'] = array('like',"%$name%");
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Cat->where($where)->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
        }
        $arr['total'] = $count;
        $arr['pageCount'] = ceil($arr['total'] / $pageSize);
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
    //操作数据
    function edit(){
        $return = ['status'=>0,'info'=>'','data'=>array()];
        $oper = I('request.oper','','string');
        $name = I('request.name','','string');      
        $catid = I('request.catid',0,'int');
        $desc = I('request.desc','','string');
        $Cat = M('cat');
        $data = ['name'=>$name,'desc'=>$desc];
        if($oper == 'add'){
            $data['addtime'] = time();
            $res = $Cat->add($data);
        }else if($oper == 'edit'){
            $res = $Cat->where(array('catid'=>$catid))->save($data);
        }else{
            $res = $Cat->where(array('catid'=>$catid))->save(array('isdel'=>1));
        }
        if($res){
            $return['status'] = 1;
            $return['info'] = '操作成功';
        }else{
            $return['info'] = '操作失败';
        }
        return $this->ajaxReturn($return);
    }
}