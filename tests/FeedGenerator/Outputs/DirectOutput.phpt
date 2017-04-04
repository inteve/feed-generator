<?php

use Inteve\FeedGenerator\Outputs\DirectOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test(function () {
	Assert::same('Lorem ipsum dolor', getOutput(function () {
		$output = new DirectOutput;
		$output->open();
		$output->output('Lorem ipsum dolor');
		$output->close();
	}));
});
