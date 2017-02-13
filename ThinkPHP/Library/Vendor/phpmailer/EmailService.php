<?php
require 'class.phpmailer.php';
class EmailService{
    /**
     * 编码格式
     * @var unknown
     */
    private $CharSet ='UTF-8';
    /**
     * SMTP 安全协议
     * @var unknown
     */
    private $SMTPSecure = 'ssl';
    /**
     * 是否开启认证
     * @var unknown
     */
    private $SMTPAuth ='true';

    /**
     * 端口号
     * @var unknown
     */
    private $Port = 25;

    /**
     * 服务域名
     * @var unknown
     */
    private $Host = 'smtp.163.com';

    /**
     * 账户邮箱
     * @var unknown
     */
    private $Username = '13711778726@163.com';

    /**
     * 账户邮箱授权密码
     * @var unknown
     */
    private $Password = 'badas520';

    /**
     * 发送者邮箱
     * @var unknown
     */
    private $From = '13711778726@163.com';

    /**
     * 发送者名称
     * @var unknown
     */
    private $FromName = '林立助';

    /**
     * 接收者邮箱
     * @var unknown
     */
    private $toUserEmail = '';

    /**
     * 邮箱标题
     * @var unknown
     */
    private $Subject = '';

    /**
     * 邮箱主体内容
     * @var unknown
     */
    private $Body = '';

    /**
     * 设置每行字符串长度
     * @var unknown
     */
    private $WordWrap = 80;

    /**
     * 备用邮件不支持html时
     * @var unknown
     */
    private $AltBody = "To view the message, please use an HTML compatible email viewer!";

    /**
     * [__set description]
     * @param [type] $key   [description]
     * @param [type] $value [description]
     */
    function mailerSend($toUserEmail,$title,$content,$file=''){

        $mail = new PHPMailer(true);
        $EmailService = new EmailService();
        print_r($EmailService);exit;
        $mail->IsSMTP();
        $mail->SMTPSecure = $EmailService->SMTPSecure;
        $mail->CharSet    = $EmailService->CharSet; //设置邮件的字符编码，这很重要，不然中文乱码
        $mail->SMTPAuth   = $EmailService->SMTPAuth;                  //开启认证
        $mail->Port       = $EmailService->Port;
        $mail->Host       = $EmailService->Host;
        $mail->Username   = $EmailService->Username;
        $mail->Password   = $EmailService->Password;
         
        //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
        $mail->AddReplyTo($EmailService->From,$EmailService->FromName);//回复地址
        $mail->From       = $EmailService->From;
        $mail->FromName   = $EmailService->FromName;
        $mail->AddAddress($toUserEmail);
        $mail->Subject    = $title;
        $mail->Body       = $content;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        $mail->WordWrap   = 80; // 设置每行字符串的长度
        if($file){
            $mail->AddAttachment($file);  //可以添加附件
        }
        $mail->IsHTML(true);
        if($mail->Send()){
            return true;
        }else{
            return false;
        }
    }
}