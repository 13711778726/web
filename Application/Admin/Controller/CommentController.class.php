<?php
namespace Admin\Controller;

class CommentController extends CommonController {
    //模板
    public function commentlist() {
        $this->display();
    }
    //数据加载
    public function commentAjax(){
        $arr = [];
        $where = ['cdb_comment.isdel'=>0];
        $Comment = M('comment');
        $count = $Comment->count();
        $page = I('request.page',1,'int');
        $status = I('request.status',-1,'int');
        if($status!=-1){
            $where['cdb_comment.status'] = $status;
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Comment->field('cdb_comment.id,cdb_comment.dyid,cdb_comment.addtime,cdb_comment.replytime,cdb_comment.content,cdb_comment.status,d.title,u.nickname')
        ->join('LEFT JOIN cdb_dynamicsinfo d ON d.dyid=cdb_comment.dyid')
        ->join('LEFT JOIN cdb_user u ON u.userid=cdb_comment.userid')
        ->where($where)->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            if($val['replytime'] == 0){
                $list[$key]['replytime'] = '';
            }else{
                $list[$key]['replytime'] = date('Y-m-d H:i:s',$val['replytime']);
            }
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
        $id = I('request.id',0,'int');
        $status = I('request.status',-1,'int');
        $Comment = M('comment');               
        if($oper == 'edit'){
            if($status == -1){
                $return['info'] = '参数缺失';
                return $this->ajaxReturn($return);
            }
            $mark = '<'.$this->admininfo['name'].'>审核评论';
            $res = $Comment->where(array('id'=>$id))->setField('status',$status);
        }else if($oper == 'del'){
            $mark = '<'.$this->admininfo['name'].'>删除评论';
            $res = $Comment->where(array('id'=>$id))->save(array('isdel'=>1));
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