<?php

use Inteve\FeedGenerator\Feeds\PostFeed\PostFeed;
use Inteve\FeedGenerator\Feeds\PostFeed\PostFeedItem;
use Inteve\FeedGenerator\InvalidItemException;
use Inteve\FeedGenerator\ItemsGroup;
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
	$items = [];
	$itemsGroup = new ItemsGroup;

	$groupItem = new PostFeedItem(1, 'Title', new DateTime('2016-02-06 18:00:00+0200', new DateTimeZone('UTC')));

	$itemsGroup->addItem($groupItem);
	$items[] = $itemsGroup;
	$items[] = NULL;

	$items[] = PostFeedItem::create('item2', 'Title 2', new DateTimeImmutable('2016-02-06 18:00:00 UTC'))
		->setImage('https://www.example.com/image.jpg')
		->setUrl('https://www.example.com/')
		->setText('Lorem ipsum dolor sit amet');

	$items[] = PostFeedItem::create('item3', 'Title 3', new DateTimeImmutable('2016-02-06 18:00:00 UTC'))
		->setMeta([
			'metadata1' => 'value1',
		]);

	$feed->setItems($items);
	$feed->generate($output);

	Assert::same(implode("\n", [
		'[',
		Json::encode([
			'id' => 1,
			'title' => 'Title',
			'date' => '2016-02-06 16:00:00',
		]) . ',',
		Json::encode([
			'id' => 'item2',
			'title' => 'Title 2',
			'date' => '2016-02-06 18:00:00',
			'text' => 'Lorem ipsum dolor sit amet',
			'url' => 'https://www.example.com/',
			'image' => 'https://www.example.com/image.jpg',
		]) . ',',
		Json::encode([
			'id' => 'item3',
			'title' => 'Title 3',
			'date' => '2016-02-06 18:00:00',
			'meta' => [
				'metadata1' => 'value1',
			],
		]),
		']',
		'',
	]), $output->getOutput());
});


test(function () {
	Assert::exception(function () {
		$output = new MemoryOutput;
		$feed = new PostFeed;
		$feed->setItems([
			'item',
		]);
		$feed->generate($output);
	}, InvalidItemException::class, 'Feed item must be instance of PostFeedItem.');
});
