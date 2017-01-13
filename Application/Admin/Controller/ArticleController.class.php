<?php
namespace Admin\Controller;
class ArticleController extends CommonController {
    //分类模板
    public function articlelist() {
        $Cat = M('cat');
        $where = ['isdel'=>0,'isshow'=>1];
        $list=$Cat->where($where)->field('id,name')->select();
        $this->assign('catlist',$list);
        $this->display();
    }
    //分类数据加载
    public function articleAjax(){
        $arr = [];
        $where = ['cdb_article.isdel'=>0];
        $Article = M('article');
        $count = $Article->count();
        $page = I('request.page',1,'int');
        $catid = I('request.catid',0,'int');
        $title = I('request.title','','string');
        if($catid!=0){
            $where['cdb_article.catid'] = $catid;
        }
        if(!empty($title)){
            $where['cdb_article.title'] = array('like',"%$title%");
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Article->field('cdb_article.*,c.name catname')
        ->where($where)
        ->join('LEFT JOIN cdb_cat c ON c.catid = cdb_article.catid')
        ->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
            if(empty($val['updatetime'])){
                $list[$key]['updatetime'] = '';
            }else{
                $list[$key]['updatetime'] = date('Y-m-d H:i:s',$val['updatetime']);
            }
            if(empty($val['img'])){
                $list[$key]['img'] = 'error.png';
            }
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
        $articleid = I('request.articleid',0,'int');
        $type = I('request.type',0,'int');
        $Article = M('article');
        if($oper == 'del'){
            $mark = '<'.$this->admininfo['name'].'>删除文章';
            $res = $Article->where(array('articleid'=>$articleid))->save(array('isdel'=>1));
        }else{
            $mark = '<'.$this->admininfo['name'].'>标记文章';
            $res = $Article->where(array('articleid'=>$articleid))->save(array('type'=>$type));
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
            $Article = M('article');
            $title = I('request.title','','string');
            $catid = I('request.catid',0,'int');
            $desc = I('request.desc','','string');
            $r_send = I('request.r_send',0,'int');
            $detail = $_POST['detail'];
            $imgs = upload($_FILES['img'],200,200);
            $img = $imgs['img'][0]['savethumbname'][0];
            $data = ['title'=>$title,'desc'=>$desc,'detail'=>$detail,'catid'=>$catid,'addtime'=>time(),'img'=>$img,'r_send'=>$r_send];
            $res = $Article->add($data);
            if($res){
                $mark = '<'.$this->admininfo['name'].'>添加文章';
                logData($this->admininfo['id'], $mark);
                $this->success('添加成功','articlelist');
            }else{
                $this->error('添加失败');
            }
        }else{
            $Cat = M('cat');
            $where = ['isdel'=>0];
            $list=$Cat->where($where)->select();
            $this->assign('catlist',$list);
            $this->display();
        }       
    }
    public function update() {
        $articleid = I('request.articleid',0,'int');
        $Article = M('article');
        $article = $Article->where(array('articleid'=>$articleid))->find();
        if(IS_POST){
            $title = I('request.title','','string');
            $catid = I('request.catid',0,'int');
            $desc = I('request.desc','','string');
            $detail = $_POST['detail'];
            $r_send = I('request.r_send',0,'int');
            $data = ['title'=>$title,'desc'=>$desc,'detail'=>$detail,'catid'=>$catid,'updatetime'=>time(),'r_send'=>$r_send];
            $imgs = upload($_FILES['img'],200,200);
            if($imgs){
                @unlink(UPLOAD_PATH.'Admin/'.$article['img']);
                $data['img'] = $imgs['img'][0]['savethumbname'][0];
            }
            $res = $Article->where(array('articleid'=>$articleid))->save($data);
            if($res){
                $mark = '<'.$this->admininfo['name'].'>修改文章';
                logData($this->admininfo['id'], $mark);
                $this->success('修改成功','articlelist');
            }else{
                $this->error('修改失败');
            }
        }else{           
            $this->assign('article',$article);
            $Cat = M('cat');
            $where = ['isdel'=>0];
            $list=$Cat->where($where)->select();
            $this->assign('catlist',$list);
            $this->display();
        }
    }
}