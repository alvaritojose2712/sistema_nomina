<?php



# pop3 mail server #

$mail_servers[] = Array(
	'profile' => 'mail.tdah.us',
	'domain' => 'mail.tdah.us',
	'server' => '192.168.1.92',
	'login_type' => '%user%@%domain%',
	'protocol' => 'pop3',
	'port' => '110');





# smtp mail server #

#_Smtp_Settings_#

	$mailer_type = 'smtp';
	$smtp_server = '192.168.1.92';
	$smtp_port = 25;
	$use_password_for_smtp = yes;
	
# only use for isp relay #	

	$smtp_static_auth = no;
	$smtp_static_user = '';
	$smtp_static_password ='';
	$smtp_secure = 'no';






?>
