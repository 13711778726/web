<?php
namespace Think\Cache\Driver;
class RedisService{
    /**
     * [$redisKey description]
     * @var string
     */
    public $redisKey='WEB_';
    
    /**
     * [$redis description]
     * @var [type]
     */
    public $redis;
    
    /**
     * [$redisObjecThis description]
     * @var null
     */
    public static $redisObjecThis=null;
    
    /**
     * [__construct description]
     * @param string $host [description]
     * @param string $port [description]
     */
    public function __construct() {
    
        $this->redis = new Redis();
        /*$host='redis1.cache.lamian.tv';
         $port='6379';*/
    
        $host='101.201.65.237';
        $port='1748';
        $this->redis->connect($host, $port);
    }
    
    /**
     * $host='redis1.cache.lamian.tv',$port='2179'
     * [RedisServiceObjec description]
     * @param string $host [description]
     * @param string $port [description]
     */
    /*public static function RedisServiceObjec($host='redis1.cache.lamian.tv',$port='6379')
     {
     $class=__CLASS__;
     if(self:: $redisObjecThis==null) {
    
     self::$redisObjecThis=new $class($host,$port);
     }
     return self::$redisObjecThis;
     }*/
    
    /**
     * 设置值  构建一个字符串
     * @param string $key KEY名称
     * @param string $value  设置值
     * @param int $timeOut 时间  0表示无过期时间
     */
    public function set($key, $value, $timeOut=0) {
    
        $key=$this->getKeyName($key);
        $retRes = $this->redis->set($key, $value);
        if ($timeOut > 0) {
    
            $this->redis->expire($key, $timeOut);
        }
        return $retRes;
    }
    
    /**
     * [getKeyName description]
     * @param  [type] $key [description]
     * @return [string]      [description]
     */
    private function getKeyName($key,$keyType=false) {
    
        if(is_array($key)) {
    
            $tmpKeyArray=array();
            foreach($key as $keys=>$value) {
    
                if($keyType) {
    
                    $tmpKeyArray[$keys]=$this->redisKey.$value;
                }else {
                    $tmpKeyArray[$this->redisKey.$keys]=$value;
                }
            }
            return $tmpKeyArray;
        }
        return $this->redisKey.$key;
    }
    
    /**
     * 判断key是否存在
     * [isExists description]
     * @param  [type]  $key [description]
     * @return boolean      [description]
     */
    public function isExists($key) {
    
        $key=$this->getKeyName($key);
        return $this->redis->exists($key);
    }
    
    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public function increment($key) {
    
        $key=$this->getKeyName($key);
        return $this->redis->incr($key);
    }
    
    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public function decrement($key) {
        $key=$this->getKeyName($key);
        return $this->redis->decr($key);
    }
    
    /**
     * 设置多个值
     * @param array $keyArray KEY名称
     * @param string|array $value 获取得到的数据
     * @param int $timeOut 时间
     */
    public function setArr($keyArray, $timeout=0) {
    
        $keyArray=$this->getKeyName($keyArray);
        if (is_array($keyArray)) {
            $retRes = $this->redis->mset($keyArray);
            if ($timeout > 0) {
                foreach ($keyArray as $key => $value) {
    
                    $this->redis->expire($key, $timeout);
                }
            }
            return $retRes;
        } else {
            return "Call  " . __FUNCTION__ . " method  parameter  Error !";
        }
    }
    
    /**
     * 通过key获取数据
     * @param string $key KEY名称
     */
    public function get($key) {
    
        $key=$this->getKeyName($key);
        $result = $this->redis->get($key);
        return $result;
    }
    
    /**
     * 同时获取多个值
     * @param ayyay $keyArray 获key数值
     */
    public function getArr($keyArray) {
    
        $keyArray=$this->getKeyName($keyArray,true);
        if (is_array($keyArray)) {
    
            return $this->redis->mget($keyArray);
        }
        return "Call  " . __FUNCTION__ . " method  parameter  Error !";
    }
    
    /**
     *add 集合
     * [zadd description]
     * @param  [type] $key   [description]
     * @param  [type] $index [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function zadd($key,$index,$value){
    
        $key=$this->getKeyName($key);
        return $this->redis->zAdd($key,$index,$value);
    }
    
    /**
     * delet集合
     * [zDelete description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function zDelete($key,$value){
    
        $key=$this->getKeyName($key);
        return $this->redis->zDelete($key,$value);
    }
    
    /**
     * count
     * [zCard description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function zCard($key){
    
        $key=$this->getKeyName($key);
        return $this->redis->zCard($key);
    }
    
    /**
     * [zScore description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function zScore($key,$value){
    
        $key=$this->getKeyName($key);
        return $this->redis->zScore($key,$value);
    }
    
    /**
     * [getKeyAll description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function getKeyAll($key)
    {
        $key=$this->getKeyName($key);
        return $this->redis->keys($key);
    }
    
    /**
     * 删除一条数据key
     * @param string $key 删除KEY的名称
     */
    public function del($key) {
    
        $key=$this->getKeyName($key);
        return $this->redis->delete($key);
    }
    
    /**
     * 同时删除多个key数据
     * @param array $keyArray KEY集合
     */
    public function dels($keyArray) {
    
        $keyArray=$this->getKeyName($keyArray,true);
        if (is_array($keyArray)) {
            return $this->redis->del($keyArray);
        } else {
            return "Call  " . __FUNCTION__ . " method  parameter  Error !";
        }
    }
}