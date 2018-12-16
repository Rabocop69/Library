<?php
/* Script name: buildForm
 *  Description: Uses the form to create a simple HTML form
 */
require_once("Form1.1.php");

echo "<html><head><title>Phone form</title></head><body>";
	  
$phone_form = new Form("process.php","Submit Phone","user");
/*
$phone_form->addField("first_name","First Name");
$phone_form->addField("last_name" ,"Last Name");
$phone_form->addField("phone","Phone");
*/
echo "<h3>Please fill in the following form:</h3>";

$phone_form->displayForm();

echo "</body></html>";
?>