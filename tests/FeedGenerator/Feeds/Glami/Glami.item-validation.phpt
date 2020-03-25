<?php

use Inteve\FeedGenerator\AssertException;
use Inteve\FeedGenerator\Feeds\Glami\GlamiFeed;
use Inteve\FeedGenerator\Feeds\Glami\GlamiItem;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$item = new GlamiItem;

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item ID, call $item->setId().');

	$item->setId(1);

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item product name, call $item->setProductName().');

	$item->setProductName('Product ABC');

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
	}, AssertException::class, 'Missing item priceVat, call $item->setPriceVat().');

	$item->setPriceVat(5);

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item category text, call $item->setCategoryText().');

	$item->setCategoryText('Glami.cz | Dámské oblečení a boty');

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item delivery date, call $item->setDeliveryDate().');

	$item->setDeliveryDate(7);

	Assert::exception(function () use ($item) {
		$item->validate();
	}, AssertException::class, 'Missing item size, call $item->setParameter(\'velikost\', $size).');

	$item->addParameter('velikost', 'XS');

	$item->validate();
});
