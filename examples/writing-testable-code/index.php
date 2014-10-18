<?php
// run composer update in case of error
require_once('vendor/autoload.php');

$app = new Newsletter();

if ($app->sendMonthly()) {
	echo 'email sent';
} else {
	echo 'email not sent';
}
