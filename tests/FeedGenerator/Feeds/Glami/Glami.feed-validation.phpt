<?php

use Inteve\FeedGenerator\Feeds\Glami\GlamiFeed;
use Inteve\FeedGenerator\Feeds\Glami\GlamiItem;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new GlamiFeed;

	$feed->setItems(array(
		array(
			'title' => 'ABC',
		),
	));

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, 'Inteve\FeedGenerator\InvalidItemException', 'Feed item must be instance of GlamiItem.');

});
