<?php
namespace Admin\Controller;
use Think\Controller;
class DynamicsController extends Controller {
    //模板
    public function taglist() {
        $this->display();
    }
    //数据加载
    public function tagAjax(){
        $arr = [];
        $where = ['isdel'=>0];
        $Tag = M('tag');
        $count = $Tag->count();
        $page = I('request.page',1,'int');
        $name = I('request.name','','string');
        if(!empty($name)){
            $where['name'] = array('like',"%$name%");
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Tag->where($where)->page($page, $pageSize)->select();
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
        $tid = I('request.tid',0,'int');
        $Tag = M('tag');
        $data = ['name'=>$name];
        if($oper == 'add'){
            $data['addtime'] = time();
            $res = $Tag->add($data);
        }else if($oper == 'edit'){
            $res = $Tag->where(array('tid'=>$tid))->save($data);
        }else{
            $res = $Tag->where(array('tid'=>$tid))->save(array('isdel'=>1));
        }
        if($res){
            $return['status'] = 1;
            $return['info'] = '操作成功';
        }else{
            $return['info'] = '操作失败';
        }
        return $this->ajaxReturn($return);
    }
    //模板
    public function dylist() {
        $where = ['isdel'=>0];
        $Tag = M('tag');
        $list=$Tag->where($where)->select();
        $this->assign('taglist',$list);
        $this->display();
    }
    //数据加载
    public function dyAjax(){
        $arr = [];
        $where = ['cdb_dynamicsinfo.isdel'=>0];
        $Dynamics = M('dynamicsinfo');
        $count = $Dynamics->count();
        $page = I('request.page',1,'int');
        $title = I('request.title','','string');
        if(!empty($title)){
            $where['cdb_dynamicsinfo.title'] = array('like',"%$title%");
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Dynamics
        ->field('cdb_dynamicsinfo.dyid,cdb_dynamicsinfo.title,cdb_dynamicsinfo.addtime,cdb_dynamicsinfo.content,cdb_dynamicsinfo.tagid,u.nickname,t.name')
        ->join('LEFT JOIN cdb_user u ON u.userid=cdb_dynamicsinfo.userid')
        ->join('LEFT JOIN cdb_tag t ON t.tid=cdb_dynamicsinfo.tagid')
        ->where($where)->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            if($val['userid'] ==0){
                $list[$key]['nickname'] = '官方用户';
            }
            $list[$key]['content'] = filcontent($val['content']);
            $list[$key]['content'] = strip_tags($list[$key]['content']);
            $list[$key]['content'] = mb_zw_string($list[$key]['content'],120);
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
        }
        $arr['total'] = $count;
        $arr['pageCount'] = ceil($arr['total'] / $pageSize);
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
    //操作数据
    function dyedit(){
        $return = ['status'=>0,'info'=>'','data'=>array()];
        $oper = I('request.oper','','string');
        $title = I('request.title','','string');
        $dyid = I('request.dyid',0,'int');
        $tagid = I('request.tagid',0,'int');
        $content = $_POST['content'];
        $Dynamics = M('dynamicsinfo');
        $data = ['title'=>$title,'content'=>$content,'tagid'=>$tagid];
        if($oper == 'add'){
            $data['addtime'] = time();
            $res = $Dynamics->add($data);
            $val = ['dyid'=>$res,'addtime'=>$data['addtime']];
            $dys = M('dynamics');
            $rs = $dys->add($val);
        }else if($oper == 'edit'){
            $res = $Dynamics->where(array('tid'=>$tid))->save($data);
        }else{
            $res = $Dynamics->where(array('tid'=>$tid))->save(array('isdel'=>1));
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