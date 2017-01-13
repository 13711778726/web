<?php
namespace Admin\Controller;

class AdvertController extends CommonController {
    //模板
    public function advertlist() {
        $this->display();
    }
    //数据加载
    public function advertAjax(){
        $arr = [];
        $where = ['isdel'=>0];
        $Advert = M('advert');
        $count = $Advert->count();
        $page = I('request.page',1,'int');
        $name = I('request.name','','string');
        if(!empty($name)){
            $where['name'] = array('like',"%$name%");
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Advert->where($where)->page($page, $pageSize)->select();
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
        $id = I('request.id',0,'int');
        $sign = I('request.sign','','string');
        $Advert = M('advert');
        $data = ['name'=>$name,'sign'=>$sign];
        if($oper == 'add'){
            $mark = '<'.$this->admininfo['name'].'>添加位置';
            $data['addtime'] = time();
            $res = $Advert->add($data);
        }else if($oper == 'edit'){
            $mark = '<'.$this->admininfo['name'].'>修改位置';
            $res = $Advert->where(array('id'=>$id))->save($data);
        }else if($oper == 'sign'){
            $isshow = I('request.isshow','-1','int');
            $mark = '<'.$this->admininfo['name'].'>标记位置';
            $res = $Advert->where(array('id'=>$id))->setField('isshow',$isshow);
        }
        else{
            $mark = '<'.$this->admininfo['name'].'>删除位置';
            $res = $Advert->where(array('id'=>$id))->save(array('isdel'=>1));
        }
        if($res){
            logData($this->admininfo['id'], $mark);
            $return['status'] = 1;
            $return['info'] = '操作成功';
        }else{
            $return['info'] = '操作失败';
        }
        return $this->ajaxReturn($return);
    }
}