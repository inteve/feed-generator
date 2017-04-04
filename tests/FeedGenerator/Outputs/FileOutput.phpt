<?php

use Inteve\FeedGenerator\Outputs\FileOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

define('TEMP_DIR', createTempDir());


test(function () {
	Assert::exception(function () {
		$output = new FileOutput(TEMP_DIR . '/output.txt');
		$output->output('Lorem ipsum dolor');
	}, 'Inteve\FeedGenerator\OutputException', 'File is not open, call open() method.');

	Assert::exception(function () {
		$output = new FileOutput(TEMP_DIR . '/output.txt');
		$output->open();
		$output->output('Lorem ipsum dolor');
		$output->close();
		$output->output('sit amet');

	}, 'Inteve\FeedGenerator\OutputException', 'File is not open, call open() method.');
});


test(function () {
	Assert::exception(function () {
		$output = new FileOutput(TEMP_DIR . '/output.txt');
		$output->output('Lorem ipsum dolor');
	}, 'Inteve\FeedGenerator\OutputException', 'File is not open, call open() method.');

	Assert::exception(function () {
		$output = new FileOutput(TEMP_DIR);
		$output->open();

	}, 'Inteve\FeedGenerator\FileSystemException', 'File \'' . TEMP_DIR . '\' is not writable.');
});


test(function () {
	$path = TEMP_DIR . '/output.txt';
	$output = new FileOutput($path);
	$output->open();
	$output->output('Lorem ipsum dolor');
	$output->close();

	Assert::same('Lorem ipsum dolor', file_get_contents($path));
});
