<?php

use Inteve\FeedGenerator\Feed;
use Inteve\FeedGenerator\InvalidArgumentException;
use Inteve\FeedGenerator\IOutput;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class TestFeed extends Feed
{
	public function generate(IOutput $output)
	{
	}


	public function getContentType()
	{
		return 'feed/test';
	}
}


test(function () {
	Assert::noError(function () {
		$feed = new TestFeed;
		$feed->setItems([]);
	});

	Assert::noError(function () {
		$feed = new TestFeed;
		$feed->setItems(new \EmptyIterator);
	});
});


test(function () {
	Assert::exception(function () {
		$feed = new TestFeed;
		$feed->setItems('');
	}, InvalidArgumentException::class, 'Items must be array or \\Traversable, string given.');

	Assert::exception(function () {
		$feed = new TestFeed;
		$feed->setItems((object) []);
	}, InvalidArgumentException::class, 'Items must be array or \\Traversable, object given.');
});
