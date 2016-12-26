<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Cache\Driver\RedisService;
class IndexController extends Controller {
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
        $host='www.linlizhu.website';
        $port='1748';
        $redis->connect($host, $port);

        $redis->set('username','redis');
        echo $redis->get('username');
        $this->display();
    }
}
