<?php

use Inteve\FeedGenerator\Feeds\PostFeed\PostFeed;
use Inteve\FeedGenerator\Feeds\PostFeed\PostFeedItem;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new PostFeed;
	$feed->generate($output);
	Assert::same('application/json', $feed->getContentType());
	Assert::same("[\n]\n", $output->getOutput());
});


test(function () {
	$output = new MemoryOutput;
	$feed = new PostFeed;
	$items = array();

	$items[] = new PostFeedItem(1, 'Title', new \DateTime('2016-02-06 18:00:00+0200'));

	$items[] = PostFeedItem::create('item2', 'Title 2', new \DateTime('2016-02-06 18:00:00 UTC'))
		->setImage('https://www.example.com/image.jpg')
		->setUrl('https://www.example.com/')
		->setText('Lorem ipsum dolor sit amet');

	$feed->setItems($items);
	$feed->generate($output);

	Assert::same(implode("\n", array(
		'[',
		Json::encode(array(
			'id' => 1,
			'title' => 'Title',
			'date' => '2016-02-06 16:00:00',
		)) . ',',
		Json::encode(array(
			'id' => 'item2',
			'title' => 'Title 2',
			'date' => '2016-02-06 18:00:00',
			'text' => 'Lorem ipsum dolor sit amet',
			'url' => 'https://www.example.com/',
			'image' => 'https://www.example.com/image.jpg',
		)),
		']',
		'',
	)), $output->getOutput());
});


test(function () {
	Assert::exception(function () {
		$output = new MemoryOutput;
		$feed = new PostFeed;
		$feed->setItems(array(
			'item',
		));
		$feed->generate($output);
	}, 'Inteve\FeedGenerator\InvalidItemException', 'Feed item must be instance of PostFeedItem.');
});
