<?php
namespace Api\Controller;
class IndexController extends CommonController {
    public function index(){
        //获取首页模块内容
        $Article = M('article');
        $arr = [];
        $articlelist = $Article
        ->field('cdb_article.articleid,cdb_article.title,cdb_article.img,cdb_article.addtime,cdb_article.type,c.name')
        ->join('LEFT JOIN cdb_cat c ON c.catid=cdb_article.catid')
        ->where(array('cdb_article.isdel'=>0))->order('cdb_article.type DESC')->select();
        foreach ($articlelist as $k=>$v){
            $articlelist[$k]['addtime'] = timeGange($v['addtime']);
            $articlelist[$k]['img'] = SITE_URL.'/Public/upload/Admin/'.$v['img'];
        }
        foreach ($articlelist as $key=>$val){            
            switch ($val['type']){
                case 0 :
                    $arr[$val['type']]['labelname'] = '首页推荐';
                    $arr[$val['type']]['list'][] = $val;
                    break;
                case 1 :
                    $arr[$val['type']]['labelname'] = '热门内容';
                    $arr[$val['type']]['list'][] = $val;
                    break;
                case 2 :
                    $arr[$val['type']]['labelname'] = '精华内容';
                    $arr[$val['type']]['list'][] = $val;
                    break;
                case 3 :
                    $arr[$val['type']]['labelname'] = '官方推荐';
                    $arr[$val['type']]['list'][] = $val;
                    break;
                case 4 :
                    $arr[$val['type']]['labelname'] = '置顶精华';
                    $arr[$val['type']]['list'][] = $val;
                    break;
            } 
        }
        $arr = array_values($arr);   //去掉数组键值
        $this->return['status'] = 1;
        $this->return['info'] = '首页内容块';
        $this->return['data'] = $arr;
        $this->ajaxReturn($this->return);
    }
}