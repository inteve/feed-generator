<?php

use Inteve\FeedGenerator\StaticClassException;
use Inteve\FeedGenerator\Utils\Helpers;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test(function () {
	Assert::exception(function () {
		$helpers = new Helpers;
	}, StaticClassException::class, 'This is static class.');
});
