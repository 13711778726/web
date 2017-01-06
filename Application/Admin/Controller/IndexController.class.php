<?php
namespace Admin\Controller;
//use Think\Cache\Driver\Redis;
class IndexController extends CommonController {
function index(){
        $this->display();
    }
    function top(){
        $this->display();
    }
    function center(){
        $this->display();
    }
    function left(){
        $priv_action = $this->admininfo['priv_action'];
        $priv_action = explode(',',$priv_action);
        $Menu = M('menu');
        $arr = [];
        if($this->admininfo['mode'] == 0){$where['parentid']!=0;}else{$where['id'] = array('in',$priv_action);}
        
        $parents = $Menu->field('id,name,url,parentid')->where(array('parentid'=>0))->select();
        $childs = $Menu->field('id,name,url,parentid')->where($where)->select();
        foreach ($parents as $key=>$val){
            $arr[$key] = $val;
            foreach ($childs as $k=>$v){               
                if($parents[$key]['id']==$v['parentid']){       
                    $arr[$key]['child'][$k] = $childs[$k];
                }
            }
            if(!isset($arr[$key]['child'])){
                unset($arr[$key]);
            } 
        }
        $this->assign('arr',$arr);
        $this->display();
    }
    function main(){
	 //$redis = new Redis();
         //$redis->set('username','my redis service ok!!');
         //echo $redis->get('username');
        $this->display();
    }
}
