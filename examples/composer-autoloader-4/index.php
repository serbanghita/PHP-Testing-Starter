<?php
if (file_exists('vendor/autoload.php')) {
	require_once('vendor/autoload.php');
}

try {
	$mc = new Mailchimp('');
	var_dump($mc);

} catch (Mailchimp_Error $e) {
   echo "You have not set an API key.\n";
}
