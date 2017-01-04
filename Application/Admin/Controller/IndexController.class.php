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
        $Menu = M('menu');
        $arr = [];
        $parents = $Menu->field('id,name,url,parentid')->where(array('parentid'=>0))->select();
        $childs = $Menu->field('id,name,url,parentid')->where('parentid!=0')->select();
        foreach ($parents as $key=>$val){
            $arr[$key] = $val;
            foreach ($childs as $k=>$v){
                if($parents[$key]['id']==$v['parentid']){
                    $arr[$key]['child'][$k] = $childs[$k];
                }
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
