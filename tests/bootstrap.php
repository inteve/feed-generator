<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test($cb)
{
	$cb();
}


function getOutput($cb)
{
	ob_start();
	$cb();
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}


function createTempDir()
{
	@mkdir(__DIR__ . '/tmp');
	$dir = __DIR__ . '/tmp/' . getmypid();
	Tester\Helpers::purge($dir);
	return $dir;
}
