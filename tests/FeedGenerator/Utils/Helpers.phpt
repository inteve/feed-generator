<?php

use Inteve\FeedGenerator\Utils\Helpers;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test(function () {
	Assert::exception(function () {
		$helpers = new Helpers;
	}, 'Inteve\FeedGenerator\StaticClassException', 'This is static class.');
});
