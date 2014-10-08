<?php
if (file_exists('vendor/autoload.php')) {
	require_once('vendor/autoload.php');
}

var_dump(\NovPDF\PDF::generateLocalPDF('<strong>Title</strong>'));
var_dump(Validation::passes());
var_dump(\HTMLForm\Form::isHtmlValid('<span>Title</span>'));
