<?php

use Inteve\FeedGenerator\Feeds\Zbozi\ZboziFeed;
use Inteve\FeedGenerator\Feeds\Zbozi\ZboziItem;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new ZboziFeed;

	$feed->setItems([
		[
			'title' => 'ABC',
		],
	]);

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, 'Inteve\FeedGenerator\InvalidItemException', 'Feed item must be instance of ZboziItem.');

});
