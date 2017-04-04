<?php

use Inteve\FeedGenerator\Feeds\GoogleMerchant\GoogleMerchantFeed;
use Inteve\FeedGenerator\Feeds\GoogleMerchant\GoogleMerchantItem;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$item = new GoogleMerchantItem;

	Assert::exception(function () use ($item) {
		$item->validate();
	}, 'Inteve\FeedGenerator\AssertException', 'Missing item ID, call $item->setId().');

	$item->setId('001');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, 'Inteve\FeedGenerator\AssertException', 'Missing item title, call $item->setTitle().');

	$item->setTitle('Product ABC');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, 'Inteve\FeedGenerator\AssertException', 'Missing item description, call $item->setDescription().');

	$item->setDescription('Lorem ipsum dolor sit amet');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, 'Inteve\FeedGenerator\AssertException', 'Missing item URL, call $item->setUrl().');

	$item->setUrl('http://www.example.com/product-abc/');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, 'Inteve\FeedGenerator\AssertException', 'Missing item image URL, call $item->setImageUrl().');

	$item->setImageUrl('http://www.example.com/images/product-abc.jpg');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, 'Inteve\FeedGenerator\AssertException', 'Missing item price, call $item->setPrice().');

	$item->setPrice(5, 'USD');
	$item->validate();
});


test(function () {
	$item = new GoogleMerchantItem;
	Assert::false($item->isAdult());
	$item->setAdult(TRUE);
	Assert::true($item->isAdult());
});


test(function () {
	$item = new GoogleMerchantItem;
	Assert::same('in stock', $item->getAvailability());

	$item->setAvailability($item::AVAILABILITY_IN_STOCK);
	Assert::same('in stock', $item->getAvailability());

	$item->setAvailability($item::AVAILABILITY_OUT_OF_STOCK);
	Assert::same('out of stock', $item->getAvailability());

	$item->setAvailability($item::AVAILABILITY_PREORDER);
	Assert::same('preorder', $item->getAvailability());

	Assert::exception(function () use ($item) {
		$item->setAvailability('invalid');
	}, 'Inteve\FeedGenerator\InvalidArgumentException', 'Invalid availability \'invalid\'.');
});


test(function () {
	$item = new GoogleMerchantItem;
	Assert::same('new', $item->getCondition());

	$item->setCondition($item::CONDITION_NEW);
	Assert::same('new', $item->getCondition());

	$item->setCondition($item::CONDITION_USED);
	Assert::same('used', $item->getCondition());

	$item->setCondition($item::CONDITION_REFURBISHED);
	Assert::same('refurbished', $item->getCondition());

	Assert::exception(function () use ($item) {
		$item->setCondition('invalid');
	}, 'Inteve\FeedGenerator\InvalidArgumentException', 'Invalid condition \'invalid\'.');
});
