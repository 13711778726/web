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
        $k0 = 0;$k1 = 0; $k2 = 0; $k3 = 0; $k4 = 0;
        foreach ($articlelist as $key=>$val){
            switch ($val['type']){
                case 0 :
                    if($k0 == 12) break;
                    $arr[$val['type']]['labelname'] = '首页推荐';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['type'] = $val['type'];
                    $k0++;
                    break;
                case 1 :
                    if($k1 == 12) break;
                    $arr[$val['type']]['labelname'] = '热门内容';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['type'] = $val['type'];
                    $k1++;
                    break;
                case 2 :
                    if($k2 == 12) break;
                    $arr[$val['type']]['labelname'] = '精华内容';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['type'] = $val['type'];
                    $k2++;
                    break;
                case 3 :
                    if($k3 == 12) break;
                    $arr[$val['type']]['labelname'] = '官方推荐';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['type'] = $val['type'];
                    $k3++;
                    break;
                case 4 :
                    if($k4 == 12) break;
                    $arr[$val['type']]['labelname'] = '置顶精华';
                    $arr[$val['type']]['list'][] = $val;
                    $arr[$val['type']]['type'] = $val['type'];
                    $k4++;
                    break;
            }
        }
        $arr = array_values($arr);   //去掉数组键值
        foreach ($arr as $k=>$v){
            $arr[$k]['clicklist'] = $Article->field('title,articleid,addtime')->where(array('type'=>$v['type']))->page(1,10)->order('clicknum DESC')->select();
            foreach ($arr[$k]['clicklist'] as $key=>$val){
                $arr[$k]['clicklist'][$key]['addtime'] = date('Y-m-d',$val['addtime']);
            }
            unset($arr[$k]['type']);
        }
        //首页banner
        $advertid = advertData('pc_index_banner_pic');
        $advertcontentDb = M('ad_content');
        $adlist = $advertcontentDb->field('title,img,url')->where(array('ad_id'=>$advertid,'isdel'=>0,'isshow'=>1))->select();
        $this->assign('adlist',$adlist);
        $this->assign('arr',$arr);
        $this->assign('catlist',$catlist);
        $this->display();
    }
}