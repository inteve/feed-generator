<?php

use Inteve\FeedGenerator\Feeds\Heureka\HeurekaFeed;
use Inteve\FeedGenerator\Feeds\Heureka\HeurekaItem;
use Inteve\FeedGenerator\InvalidItemException;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new HeurekaFeed;

	$feed->setItems([
		[
			'title' => 'ABC',
		],
	]);

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, InvalidItemException::class, 'Feed item must be instance of HeurekaItem.');

});
