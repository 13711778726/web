<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends Controller {
    //分类模板
    public function articlelist() {
        $Cat = M('cat');
        $where = ['isdel'=>0];
        $list=$Cat->where($where)->select();
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
        $Article = M('article');
        if($oper == 'del'){
            $res = $Article->where(array('articleid'=>$articleid))->save(array('isdel'=>1));
        }
        if($res){
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
            $detail = $_POST['detail'];
            $data = ['title'=>$title,'desc'=>$desc,'detail'=>$detail,'catid'=>$catid,'addtime'=>time()];
            $res = $Article->add($data);
            if($res){
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
        if(IS_POST){
            $title = I('request.title','','string');
            $catid = I('request.catid',0,'int');
            $desc = I('request.desc','','string');
            $detail = $_POST['detail'];
            $data = ['title'=>$title,'desc'=>$desc,'detail'=>$detail,'catid'=>$catid];
            $res = $Article->where(array('articleid'=>$articleid))->save($data);
            if($res){
                $this->success('修改成功','articlelist');
            }else{
                $this->error('修改失败');
            }
        }else{
            $article = $Article->where(array('articleid'=>$articleid))->find();
            $this->assign('article',$article);
            $Cat = M('cat');
            $where = ['isdel'=>0];
            $list=$Cat->where($where)->select();
            $this->assign('catlist',$list);
            $this->display();
        }
    }
}