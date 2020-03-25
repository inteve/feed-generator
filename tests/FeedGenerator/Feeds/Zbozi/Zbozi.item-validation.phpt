<?php

use Inteve\FeedGenerator\AssertException;
use Inteve\FeedGenerator\Feeds\Zbozi\ZboziFeed;
use Inteve\FeedGenerator\Feeds\Zbozi\ZboziItem;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$item = new ZboziItem;

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item product name, call $item->setProductName().');

	$item->setProductName('Product ABC');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item description, call $item->setDescription().');

	$item->setDescription('Lorem ipsum dolor sit amet');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item URL, call $item->setUrl().');

	$item->setUrl('http://www.example.com/product-abc/');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item image URL, call $item->setImageUrl().');

	$item->setImageUrl('http://www.example.com/images/product-abc.jpg');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item price, call $item->setPrice().');

	$item->setPrice(5, 'USD');
	$item->validate();
});
