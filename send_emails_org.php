<?php

require_once('includes/swift/lib/swift_required.php');


$username = "umikoariko";
$email_password = "umineko1234";
$email_from = "umikoariko@gmail.com";
$from_name = "Umi Neko";


function generate_email_content($name, $project1, $project2){
	$content = "Dear " . $name .",

	Thank you for your interest on " . $club . "
	
	You have been assigned as a reviewer for the following two final project proposals: " . $project1 . " and " . $project2 . "

	* Do you have any suggestions for related work that should be cited?";

	return $content;
}

function send_email($email_to, $content, $subject){

	global $username;
	global $email_password;
	global $email_from;
	global $from_name;

	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl");
	$transport->setUsername($username);
	$transport->setPassword($email_password);

	//create the mailer object which will send the email
	$mailer = Swift_Mailer::newInstance($transport);

	//create arrays holding the information about sender and receiver
	$from = array($email_from => $from_name);
	$to = array($email_to);

	//setup the body of the emal
	$email_subject = $subject;
	$email_body = $content;

	//create the message object using the variables we defined above
	$message = Swift_Message::newInstance($email_subject);
	$message->setFrom($from);
	$message->setTo($to);
	$message->setBody($email_body);

	//finally, send it!
	$result = $mailer->send($message);

}


//load CSV

//load data

$handle = fopen("review_assignments.csv", "r");

if ($handle) {
	
	$counter = 0;
	
	//the first line is the header, so we should just read it and advance the file pointer to the next line
	fgetcsv($handle, 1000, ";");
	
	while (true) {		

		if ( feof($handle) )
			break;
		
		$data = fgetcsv($handle, 1000, ";");
		
		$email_to = $data[0]."@iastate.edu";
		$student_name = $data[1];
		
		$project1 = $data[2];
		$project2 = $data[3];
		
		$email_content = generate_email_content($student_name,$project1,$project2);
		
		
		
		echo "Sending email to $email_to<br><br><br>";
		echo $email_content . "<br><br><br><br>";
		
		//send_email($email_to,$email_content,"HCI 573 Proposal Review Assignments");
		
		
		$counter++;
	}
	
	fclose($handle);
}





?>