<?php
namespace Index\Controller;
class IndexController extends CommonController {
    public function index(){
        //获取导航菜单
        $catlist = $this->catlist();
        //获取首页模块内容
        $Article = M('article');
        $arr = [];
        $articlelist = $Article
        ->field('cdb_article.articleid,cdb_article.title,cdb_article.img,cdb_article.addtime,cdb_article.type,cdb_article.clicknum,c.name')
        ->join('LEFT JOIN cdb_cat c ON c.catid=cdb_article.catid')
        ->where(array('cdb_article.isdel'=>0))->order('cdb_article.addtime DESC')->select();
        foreach ($articlelist as $k=>$v){
            $articlelist[$k]['addtime'] = timeGange($v['addtime']);
            $articlelist[$k]['img'] = SITE_URL.'/Public/upload/Admin/'.$v['img'];
        }
        foreach ($articlelist as $key=>$val){
            switch ($val['type']){
                case 0 :
                    $arr[$val['type']]['labelname'] = '首页推荐';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['clicknum'][] = $val['clicknum'];
                    break;
                case 1 :
                    $arr[$val['type']]['labelname'] = '热门内容';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['clicknum'][] = $val['clicknum'];
                    break;
                case 2 :
                    $arr[$val['type']]['labelname'] = '精华内容';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['clicknum'][] = $val['clicknum'];
                    break;
                case 3 :
                    $arr[$val['type']]['labelname'] = '官方推荐';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['clicknum'][] = $val['clicknum'];
                    break;
                case 4 :
                    $arr[$val['type']]['labelname'] = '置顶精华';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['clicknum'][] = $val['clicknum'];
                    break;
            }
        }
        $arr = array_values($arr);   //去掉数组键值
        foreach ($arr as $k=>$v){
            $arr[$k]['clicklist'] = sortByIds($v['list'],$v['clicknum'],'clicknum');
            array_multisort($v['clicknum'],SORT_DESC,$arr[$k]['clicklist']);//按阅读量排序
            unset($arr[$k]['clicknum']);
        }
        $this->assign('arr',$arr);
        $this->assign('catlist',$catlist);
        $this->display();
    }
}