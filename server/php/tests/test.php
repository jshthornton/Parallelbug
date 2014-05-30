<?php
include_once('../src/Output2Web.php');

Output2Web::$dir = __DIR__ . DIRECTORY_SEPARATOR . 'logs';

var_dump(Output2Web::dump(array(
	'blah'
), array(
	'filename' => 'array'
)));

var_dump(Output2Web::dump(array(
	'foo' => 'blah'
), array(
	'filename' => 'ass_array'
)));


var_dump(Output2Web::dump(true, array(
	'filename' => 'true'
)));

var_dump(Output2Web::dump(false, array(
	'filename' => 'false'
)));

var_dump(Output2Web::dump((object) array('property' => 'value'), array(
	'filename' => 'object'
)));

var_dump(Output2Web::dump(function() { $balh = 'hello'; }, array(
	'filename' => 'function'
)));

