<?php
include_once('../src/Parallelbug.php');

Parallelbug::$dir = __DIR__ . DIRECTORY_SEPARATOR . 'logs';

var_dump(Parallelbug::dump(array(
	'blah'
), array(
	'filename' => 'array'
)));

var_dump(Parallelbug::dump(array(
	'foo' => 'blah'
), array(
	'filename' => 'ass_array'
)));

// Supposed to fail
var_dump(Parallelbug::dump(array(
	'foo' => 'blah'
), array(
	'filename' => 'append_fail',
	'append' => true
)));

var_dump(Parallelbug::dump(array(
	'foo' => 'blah'
), array(
	'filename' => 'append'
)));

var_dump(Parallelbug::dump(array(
	'foo' => 'blah'
), array(
	'filename' => 'append',
	'append' => true
)));


var_dump(Parallelbug::dump(true, array(
	'filename' => 'true'
)));

var_dump(Parallelbug::dump(false, array(
	'filename' => 'false'
)));

var_dump(Parallelbug::dump((object) array('property' => 'value'), array(
	'filename' => 'object'
)));

var_dump(Parallelbug::dump(function() { $balh = 'hello'; }, array(
	'filename' => 'function'
)));

