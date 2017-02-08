<?php
namespace Api\Controller;
class IndexController extends CommonController {
    public function index(){
        //获取首页模块内容
        $Article = M('article');
        $arr = [];
        $str = [];
        $wheres = ['cdb_article.isdel'=>0];
        $catid = I('request.catid',0,'int');
        if($catid != 0){
            $wheres['cdb_article.catid'] = $catid;
        }
        $articlelist = $Article
        ->field('cdb_article.articleid,cdb_article.title,cdb_article.img,cdb_article.addtime,cdb_article.type,c.name,cdb_article.clicknum,cdb_article.collectnum')
        ->join('LEFT JOIN cdb_cat c ON c.catid=cdb_article.catid')
        ->where($wheres)->order('cdb_article.addtime DESC')->select();
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
        //首页导航
        $Cat = M('cat');
        $where = ['isdel'=>0,'isshow'=>1];
        $list=$Cat->where($where)->field('catid,name')->select();
        $str['catlist'] = $list;
        //首页幻灯
        $advertid = advertData('app_index_banner_pic');
        $advertcontentDb = M('ad_content');
        $adlist = $advertcontentDb->field('title,img,url')->where(array('ad_id'=>$advertid,'isdel'=>0,'isshow'=>1))->select();
        $str['adlist'] = $adlist;
        $str['artlist'] = array_values($arr);   //去掉数组键值
        $this->return['status'] = 1;
        $this->return['info'] = '首页内容块';
        $this->return['data'] = $str;
        $this->ajaxReturn($this->return);
    }
}