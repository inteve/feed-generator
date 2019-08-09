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

	$items[] = new PostFeedItem(1, 'Title', new DateTime('2016-02-06 18:00:00+0200', new DateTimeZone('UTC')));

	$items[] = PostFeedItem::create('item2', 'Title 2', new DateTimeImmutable('2016-02-06 18:00:00 UTC'))
		->setImage('https://www.example.com/image.jpg')
		->setUrl('https://www.example.com/')
		->setText('Lorem ipsum dolor sit amet');

	$items[] = PostFeedItem::create('item3', 'Title 3', new DateTimeImmutable('2016-02-06 18:00:00 UTC'))
		->setMeta(array(
			'metadata1' => 'value1',
		));

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
		)) . ',',
		Json::encode(array(
			'id' => 'item3',
			'title' => 'Title 3',
			'date' => '2016-02-06 18:00:00',
			'meta' => array(
				'metadata1' => 'value1',
			),
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
