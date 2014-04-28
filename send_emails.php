<?php

require_once('includes/swift/lib/swift_required.php');


$username = "jsinapov";
$email_password = "";
$email_from = "jsinapov@gmail.com";
$from_name = "Jivko Sinapov";


function generate_email_content($name, $project1, $project2){
	$content = "Dear " . $name .",

	You have been assigned as a reviewer for the following two final project proposals: " . $project1 . " and " . $project2 . "

	The proposals can be found on the BlackBoard discussion forum. Please save each review as a .txt file, titled “[netid]_review1.txt” and “[netid]_review2.txt” where [netid] is your ISU username. This review is single-blind so do not include your name anywhere in the review.

	Please send your reviews back to both TAs as two attachments to the same e-mail. To expedite processing please use the following subject line \"HCI 573: Proposal Reviews\".

	The reviews are due on Friday March 28th, 2013 (by midnight).


	REVIEW GUIDELINES

	Each review should start with the following information

	1. Proposal title and team members of the proposal:

	2. Should this proposal be considered for the Best Proposal prize? (yes/no):

	3. On a scale of 1 to 10, how would you rate the overall organization/clarity of the proposal? (1-10):

	4. On a scale of 1 to 10, how would you rate the overall project idea?(1-10):

	Then write 4-5 paragraphs of helpful feedback to the proposal's author(s). The following questions should help you organize your feedback:

	* Overall, is the proposal clear, concise, and well-organized?

	* Does the proposal meet the posted proposal guidelines?

	* How does the project idea fit within the goals of this class?

	* Describe what you like BEST about the project idea.

	* Describe what you like LEAST about the project idea.

	* Does it seem doable in the remaining time?

	* Does it seem too difficult?

	* Are there any major details left out?

	* Do you have any suggestions for improvement?

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