<?php

use Inteve\FeedGenerator\AssertException;
use Inteve\FeedGenerator\Feeds\GoogleMerchant\GoogleMerchantFeed;
use Inteve\FeedGenerator\Feeds\GoogleMerchant\GoogleMerchantItem;
use Inteve\FeedGenerator\InvalidItemException;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new GoogleMerchantFeed;

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, AssertException::class, 'Missing title, call $feed->setTitle().');

	$feed->setTitle('Products');

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, AssertException::class, 'Missing website URL, call $feed->setWebsiteUrl().');

	$feed->setWebsiteUrl('http://www.example.com/');

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, AssertException::class, 'Missing update date, call $feed->setUpdated().');

	$feed->setUpdated(new DateTimeImmutable('2017-01-01 00:00:00 UTC'));

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, AssertException::class, 'Missing author, call $feed->setAuthor().');

	$feed->setAuthor('Example.com');

	$feed->generate($output);

	Assert::same(implode("\n", [
		'<?xml version="1.0" encoding="utf-8"?>',
		'<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">',
		'<title>Products</title>',
		'<link href="http://www.example.com/" rel="alternate" type="text/html" />',
		'<updated>2017-01-01T00:00:00+00:00</updated>',
		'<author>',
		'<name>Example.com</name>',
		'</author>',
		'</feed>',
		'',
	]), $output->getOutput());
});


test(function () {
	$output = new MemoryOutput;
	$feed = new GoogleMerchantFeed;
	$feed->setTitle('Products');
	$feed->setWebsiteUrl('http://www.example.com/');
	$feed->setUpdated(new DateTimeImmutable('2017-01-01 00:00:00 UTC'));
	$feed->setAuthor('Example.com');

	$feed->setItems([
		[
			'title' => 'ABC',
		],
	]);

	Assert::exception(function () use ($feed, $output) {
		$feed->generate($output);
	}, InvalidItemException::class, 'Feed item must be instance of GoogleMerchantItem.');

});
