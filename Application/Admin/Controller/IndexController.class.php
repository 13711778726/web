<?php
namespace Admin\Controller;
use Think\Cache\Driver\Redis;
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
        $this->display();
    }
    function main(){
	 $redis = new Redis();
         $redis->set('username','my redis service ok!!');
         echo $redis->get('username');
        $this->display();
    }
}
