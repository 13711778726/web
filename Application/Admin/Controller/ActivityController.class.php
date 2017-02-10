<?php
namespace Admin\Controller;
class ActivityController extends CommonController {
    public function activity() {
        $this->display();
    }
    public function activityAjax(){
        $arr = [];
        $where = ['isdel'=>0];
        $Award = M('award');
        $count = $Award->count();
        $page = I('request.page',1,'int');
        $pageSize = I('request.rows',20,'int');
        $list=$Award->where($where)->page($page, $pageSize)->select();
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
        $desc = I('request.desc','','string');
        $num = I('request.num',0,'int');
        $gailv = I('request.gailv',0,'int');
        $sort = I('request.sort',0,'int');
        $Award = M('award');
        $data = ['name'=>$name,'desc'=>$desc,'num'=>$num,'gailv'=>$gailv,'sort'=>$sort];
        if($oper == 'edit'){
            $mark = '<'.$this->admininfo['name'].'>设置奖品';
            $res = $Award->where(array('id'=>$id))->save($data);
        }
        else{
            $mark = '<'.$this->admininfo['name'].'>删除奖品';
            $res = $Award->where(array('id'=>$id))->save(array('isdel'=>1));
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
    public function add() {
        if(IS_POST){
            $Award = M('award');
            $name = I('request.name','','string');
            $desc = I('request.desc','','string');
            $num = I('request.num',0,'int');
            $gailv = I('request.gailv',0,'int');
            $sort = I('request.sort',0,'int');
            $imgs = upload($_FILES['img'],200,100);
            $img = $imgs['img'][0]['savethumbname'][0];
            $data = ['name'=>$name,'desc'=>$desc,'num'=>$num,'gailv'=>$gailv,'sort'=>$sort,'img'=>$img];
            $res = $Award->add($data);
            if($res){
                $mark = '<'.$this->admininfo['name'].'>添加奖品';
                logData($this->admininfo['id'], $mark);
                $this->success('添加成功','activity');
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }
    public function update() {
        $id = I('request.id',0,'int');
        $Award = M('award');
        $info = $Award->where(array('id'=>$id))->find();
        if(IS_POST){
            $name = I('request.name','','string');
            $id = I('request.id',0,'int');
            $desc = I('request.desc','','string');
            $num = I('request.num',0,'int');
            $gailv = I('request.gailv',0,'int');
            $sort = I('request.sort',0,'int');
            $data = ['name'=>$name,'desc'=>$desc,'num'=>$num,'gailv'=>$gailv,'sort'=>$sort];
            $imgs = upload($_FILES['img'],200,100);
            if($imgs){
                @unlink(UPLOAD_PATH.'Admin/'.$info['img']);
                $data['img'] = $imgs['img'][0]['savethumbname'][0];
            }
            $res = $Award->where(array('id'=>$id))->save($data);
            if($res){
                $mark = '<'.$this->admininfo['name'].'>修改奖品';
                logData($this->admininfo['id'], $mark);
                $this->success('修改成功','activity');
            }else{
                $this->error('修改失败');
            }
        }else{
            $this->assign('info',$info);
            $this->display();
        }
    }
    public function awardrecord() {
        $this->display();
    }
    public function awardrecordAjax() {
        $arr = [];
        $where = [];
        $AwardRecord = M('award_record');
        $count = $AwardRecord->count();
        $page = I('request.page',1,'int');
        $pageSize = I('request.rows',20,'int');
        $status = I('request.status',-1,'int');
        $awardid = I('request.awardid',-1,'int');
        if($status!='-1'){
            $where['cdb_award_record.status'] = $status;
        }
        if($awardid!='-1'){
            if($awardid == 0){
                $where['cdb_award_record.awardid'] = $awardid;
            }else{
                $where['cdb_award_record.awardid'] = array('neq',0);
            }           
        }
        $list=$AwardRecord->where($where)->field('cdb_award_record.*,u.nickname')
        ->join('LEFT JOIN cdb_user u ON u.userid=cdb_award_record.userid')
        ->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
        }
        $arr['total'] = $count;
        $arr['pageCount'] = ceil($arr['total'] / $pageSize);
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
}