<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright 2021 KOVATZ.COM
*
*/

//Default PHP Mail
function default_mail ($from,$yourName,$replyTo,$replyName,$sentTo,$subject,$body) {

    $mail = new PHPMailer(); 
    
    $mail->CharSet = 'UTF-8'; 

    if(DEFAULT_FROM_ADDRESS != '')
        $from = DEFAULT_FROM_ADDRESS;

    if(DEFAULT_FROM_NAME != '')
        $yourName = DEFAULT_FROM_NAME;

    $mail->SetFrom($from, $yourName);
    
    $mail->AddReplyTo($replyTo,$replyName);

    $mail->AddAddress($sentTo);
    
    $mail->Subject = $subject;
    
    $mail->IsHTML(true);
    
    $mail->MsgHTML($body);
    
    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    
    if(!$mail->Send()) {
        //Mail Failed -> Debug: $mail->ErrorInfo;
        return false;
    } else {
        //Message has been sent
      return true;
    }
}

//SMTP Mail
function smtp_mail ($smtp_host,$smtp_port=587,$smtp_auth,$smtp_user,$smtp_pass,$smtp_sec='tls',$from,$yourName,$replyTo,$replyName,$sentTo,$subject,$body) {
    $mail = new PHPMailer;
    $mail->IsSMTP();                
    $mail->Host = $smtp_host;           
    $mail->Port = $smtp_port;                           
    $mail->SMTPAuth = $smtp_auth;                              
    $mail->Username = $smtp_user;              
    $mail->Password = $smtp_pass;                 
    $mail->SMTPSecure = $smtp_sec;     
    $mail->CharSet = 'UTF-8';

    if(DEFAULT_FROM_ADDRESS != '')
        $from = DEFAULT_FROM_ADDRESS;

    if(DEFAULT_FROM_NAME != '')
        $yourName = DEFAULT_FROM_NAME;

    $mail->SetFrom($from, $yourName);
    $mail->AddReplyTo($replyTo,$replyName);
    $mail->AddAddress($sentTo); 
    
    $mail->IsHTML(true);                
    
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    
    if(!$mail->Send()) {
        //Mail Failed -> Debug: $mail->ErrorInfo;
        return false;
    } else{
      //Message has been sent
      return true;
    }
}
