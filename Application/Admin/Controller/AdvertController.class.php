<?php
namespace Admin\Controller;

class AdvertController extends CommonController {
    //模板
    public function advertlist() {
        $this->display();
    }
    //位置数据加载
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
    //位置操作数据
    function edit(){
        $return = ['status'=>0,'info'=>'','data'=>array()];
        $oper = I('request.oper','','string');
        $name = I('request.name','','string');      
        $id = I('request.id',0,'int');
        $sign = I('request.sign','','string');
        $type = I('request.type',0,'int');
        $Advert = M('advert');
        $data = ['name'=>$name,'sign'=>$sign,'type'=>$type];
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
    
    function advertcontent(){
        $Advert = M('advert');
        $where = ['isdel'=>0,'isshow'=>1];
        $list=$Advert->where($where)->field('id,name')->select();
        $this->assign('advertlist',$list);
        $this->display();
    }
    //位置内容
    function advertcontentAjax(){
        $arr = [];
        $where = ['cdb_ad_content.isdel'=>0];
        $Advertcontent = M('ad_content');
        $count = $Advertcontent->count();
        $page = I('request.page',1,'int');
        $ad_id = I('request.ad_id',-1,'int');
        if($ad_id != -1){
            $where['cdb_ad_content.ad_id'] = $ad_id;
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Advertcontent->where($where)
        ->field('a.name,cdb_ad_content.*')->join('LEFT JOIN cdb_advert a ON a.id=cdb_ad_content.ad_id AND a.isshow=1')->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
        }
        $arr['total'] = $count;
        $arr['pageCount'] = ceil($arr['total'] / $pageSize);
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
    //位置内容删除、标记
    function editad(){
        $return = ['status'=>0,'info'=>'','data'=>array()];
        $oper = I('request.oper','','string');
        $id = I('request.id',0,'int');
        $isshow = I('request.isshow',0,'int');
        $Advertcontent = M('ad_content');
        if($oper == 'del'){
            $mark = '<'.$this->admininfo['name'].'>删除位置';
            $res = $Advertcontent->where(array('id'=>$id))->save(array('isdel'=>1));
        }elseif($oper == 'sign'){
            $mark = '<'.$this->admininfo['name'].'>标记位置';
            $res = $Advertcontent->where(array('id'=>$id))->save(array('isshow'=>$isshow));
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
    //位置内容添加
    function add(){                      
        if(IS_POST){
            $Advertcontent = M('ad_content');
            $ad_type = I('request.ad_type',0,'int');
            $title = I('request.title','','string');
            $content = I('request.content','','string');
            $width = I('request.width','200','int');
            $height = I('request.height','200','int');
            $ad_id = I('request.ad_id',0,'int');
            $url = I('request.url','','string');
            $imgs = upload($_FILES['img'],$width,$height);
            if($imgs){
                $img = $imgs['img'][0]['savethumbname'][0];
            }else{
                $img = '';
            }          
            $data = ['ad_type'=>$ad_type,'title'=>$title,'content'=>$content,'width'=>$width,'height'=>$height,'addtime'=>time(),'img'=>$img,'ad_id'=>$ad_id,'url'=>$url];
            $res = $Advertcontent->add($data);
            if($res){
                $mark = '<'.$this->admininfo['name'].'>添加位置内容';
                logData($this->admininfo['id'], $mark);
                $this->success('添加成功','advertcontent');
            }else{
                $this->error('添加失败');
            }
        }else{
            $Advert = M('advert');
            $where = ['isdel'=>0,'isshow'=>1];
            $list=$Advert->where($where)->field('id,name')->select();
            $this->assign('advertlist',$list);
            $this->display();
        }
    }
    //位置内容修改
    function update(){
        $id = I('request.id',0,'int');
        $Advertcontent = M('ad_content');
        $info = $Advertcontent->where(array('id'=>$id))->find();
        if(IS_POST){
            $ad_type = I('request.ad_type',0,'int');
            $title = I('request.title','','string');
            $content = I('request.content','','string');
            $width = I('request.width','200','int');
            $height = I('request.height','200','int');
            $imgs = upload($_FILES['img'],$width,$height);
            $ad_id = I('request.ad_id',0,'int');
            $url = I('request.url','','string');
            $data = ['ad_type'=>$ad_type,'title'=>$title,'content'=>$content,'width'=>$width,'height'=>$height,'ad_id'=>$ad_id,'url'=>$url];
            if($imgs){
                @unlink(UPLOAD_PATH.'Admin/'.$info['img']);
                $data['img'] = $imgs['img'][0]['savethumbname'][0];
            }           
            $res = $Advertcontent->where(array('id'=>$id))->save($data);
            if($res){
                $mark = '<'.$this->admininfo['name'].'>修改位置内容';
                logData($this->admininfo['id'], $mark);
                $this->success('修改成功','advertcontent');
            }else{
                $this->error('修改失败');
            }
        }else{
            $Advert = M('advert');
            $where = ['isdel'=>0,'isshow'=>1];
            $list=$Advert->where($where)->field('id,name')->select();
            $this->assign('advertlist',$list);
            $this->assign('info',$info);
            $this->display();
        }
    }
}