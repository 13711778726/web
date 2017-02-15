<?php
namespace Api\Controller;
class DynamicsController extends CommonController {
    //动态信息
    public function dylist() {
        $page = I('request.page',1,'int');
        $rows = I('request.rows',10,'int');
        //获取我的好友
        $friend = M('friend');
        $ruserid = $friend->field('ruserid')->where(array('userid'=>$this->userid))->select();
        if(!empty($ruserid)){array_push($ruserid,0);}else{$ruserid = [0];}       
        //获取好友和官方动态
        $dynamics = M('dynamicsinfo');       
        $where['cdb_dynamicsinfo.userid'] = array('in',$ruserid);
        $list = $dynamics
        ->field('cdb_dynamicsinfo.dyid,cdb_dynamicsinfo.title,cdb_dynamicsinfo.addtime,cdb_dynamicsinfo.content,cdb_dynamicsinfo.tagid,u.nickname,u.userimg,t.name')
        ->join('LEFT JOIN cdb_user u ON u.userid=cdb_dynamicsinfo.userid')
        ->join('LEFT JOIN cdb_tag t ON t.tid=cdb_dynamicsinfo.tagid')
        ->where($where)->order('cdb_dynamicsinfo.addtime DESC')->page($page,$rows)->select();
        if(empty($list)){
            $this->return['info'] = '动态数据为空';
            $this->ajaxReturn($this->return);
        }
        foreach ($list as $key => $val){
            $list[$key]['addtime'] = timeGange($val['addtime']);
            if($val['userid'] ==0){
                $list[$key]['nickname'] = '官方用户';
            }
            if(empty($list[$key]['nickname'])){
                $list[$key]['nickname'] = '我是小贝贝';
            }
            if(empty($val['userimg'])){
                $list[$key]['userimg'] = SITE_URL.'/Public/upload/Admin/error.png';
            }else{
                $list[$key]['userimg'] = SITE_URL.'/Public/upload/Admin/'.$val['userimg'];
            }
        }
        $this->return['status'] = 1;
        $this->return['info'] = '动态数据';
        $this->return['data'] = $list;
        $this->ajaxReturn($this->return);      
    }
    //发布动态
    public function postdynamics() {
        if(IS_POST){
            $dynamics = M('dynamicsinfo');
            $this->isLogin();
            $title = I('request.title','','string');
            $tagid = I('request.tagid',0,'int');
            $content = $_POST['content'];
            $data = ['userid'=>$this->userid,'title'=>$title,'tagid'=>$tagid,'content'=>$content,'addtime'=>time()];
            $res = $dynamics->add($data);
            if($res){
                $dyn = M('dynamics');
                $val = ['dyid'=>$res,'type'=>1,'addtime'=>$data['addtime']];
                $dyn->add($val);
                $this->return['status'] = 1;
                $this->return['info'] = '发布成功';
                $this->ajaxReturn($this->return);
            }else{
                $this->return['info'] = '发布失败';
                $this->ajaxReturn($this->return);                
            }
        }else{
            $where = ['isdel'=>0];
            $Tag = M('tag');
            $list=$Tag->where($where)->select();
            $this->return['status'] = 1;
            $this->return['info'] = '动态标签';
            $this->return['data'] = $list;
            $this->ajaxReturn($this->return);
        }
    }
}