<?php
namespace Index\Controller;
class ActivityController extends CommonController {
    public function index(){
        $Award = M('award');
        $awardList = $Award->where(array('isdel'=>0,'gailv'=>array('GT',0),'num'=>array('GT',0)))->select();
        $this->assign('awardlist',$awardList);
        $this->display();        
    }
    
    public function awardAjax(){
        $Award = M('award');
        $awardList = $Award->where(array('isdel'=>0,'gailv'=>array('GT',0),'num'=>array('GT',0)))->select();
        if(empty($awardList)){
            $this->return['info'] = '奖品已经被领完';
            $this->ajaxReturn($this->return);
        }
        $awardCount = $Award->count();
        
        //概率数组
        $gailvs = [];
        foreach ($awardList as $key=>$val){
            array_push($gailvs,$val['gailv']);
        }
        //获取最小公倍数$temp
        for ($i=0;$i<$awardCount;$i++){
            if($i == 0){
                $temp=Lnum(1,$gailvs[$i]);
            }else{
                $temp=Lnum($temp,$gailvs[$i]);
            }
        }
        
        //根据最小公倍数给奖品list分区间([2,5]最小公倍数10,则区间为[1-5],[6-7],[8-10])
        foreach ($awardList as $key=>$val){
            if($key == 0){
                $awardList[$key]['interval'] = $temp/$val['gailv'];
            }else{
                $awardList[$key]['interval'] = ($temp/$val['gailv'])+$awardList[$key-1]['interval'];
            }
        }
        
        //把未中奖区间加入奖品列(id值为0)
        array_push($awardList,array('id'=>0,'name'=>'抱歉您未中奖','gailv'=>'','interval'=>$temp,'img'=>''));
        
        //抽奖中奖结果(返回中奖的数组列,包括未中奖列)
        $result = award_rand($awardList,$temp);
        $AwardRecord = M('award_record');
        $data = ['userid'=>1,'addtime'=>time(),'awardid'=>$result['id']];
        if($result['id']!=0){
            //中奖
            $data['mark'] = '中了'.$result['name'];
            $Award->where(array('id'=>$result['id']))->setDec('num',1);  //奖品数量减一
            $this->return['status'] = 1;
            $this->return['info'] = '恭喜您中了奖品'.$result['name'];
        }else{
            $data['mark'] = '未中奖';
            $this->return['info'] = $result['name'];
        }
        $AwardRecord->add($data);
        $this->ajaxReturn($this->return);
    }
}