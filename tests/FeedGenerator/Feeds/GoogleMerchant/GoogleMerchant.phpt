<?php

use Inteve\FeedGenerator\Feeds\GoogleMerchant\GoogleMerchantFeed;
use Inteve\FeedGenerator\Feeds\GoogleMerchant\GoogleMerchantItem;
use Inteve\FeedGenerator\ItemsGroup;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new GoogleMerchantFeed;
	$feed->setTitle('Products');
	$feed->setWebsiteUrl('http://www.example.com/');
	$feed->setUpdated(new DateTimeImmutable('2017-01-01 00:00:00 UTC'));
	$feed->setAuthor('Example.com');
	$itemsGroup = new ItemsGroup;

	$groupItem = GoogleMerchantItem::create()
		->setId('001')
		->setTitle('Product ABC')
		->setDescription('Lorem ipsum dolor sit amet')
		->setUrl('http://www.example.com/product-abc/')
		->setImageUrl('http://www.example.com/images/product-abc.jpg')
		->addAlternativeImageUrl('http://www.example.com/images/product-abc-2.jpg')
		->addAlternativeImageUrl('http://www.example.com/images/product-abc-3.jpg')
		->setPrice(5, 'USD')
		->setBrand('Brand')
		->setGroupId('AB12345')
		->setProductType('Category')
		->setColor('red')
		->setGender('male')
		->setSize('XXL')
		->setShipping(10, 'USD')
		->setShippingLabel('Only FedEx');

	$itemsGroup->addItem($groupItem);
	$itemsGroup->addItem($groupItem);
	$feed->setItems([$itemsGroup, NULL]);
	$feed->generate($output);

	Assert::same('application/atom+xml', $feed->getContentType());

	Assert::same(implode("\n", [
		'<?xml version="1.0" encoding="utf-8"?>',
		'<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">',
		'<title>Products</title>',
		'<link href="http://www.example.com/" rel="alternate" type="text/html" />',
		'<updated>2017-01-01T00:00:00+00:00</updated>',
		'<author>',
		'<name>Example.com</name>',
		'</author>',
		'<entry>',
		'<g:id>001</g:id>',
		'<g:title>Product ABC</g:title>',
		'<g:description>Lorem ipsum dolor sit amet</g:description>',
		'<g:link>http://www.example.com/product-abc/</g:link>',
		'<g:image_link>http://www.example.com/images/product-abc.jpg</g:image_link>',
		'<g:additional_image_link>http://www.example.com/images/product-abc-2.jpg</g:additional_image_link>',
		'<g:additional_image_link>http://www.example.com/images/product-abc-3.jpg</g:additional_image_link>',
		'<g:availability>in stock</g:availability>',
		'<g:price>5.00 USD</g:price>',
		'<g:brand>Brand</g:brand>',
		'<g:identifier_exists>no</g:identifier_exists>',
		'<g:condition>new</g:condition>',
		'<g:adult>no</g:adult>',
		'<g:color>red</g:color>',
		'<g:gender>male</g:gender>',
		'<g:size>XXL</g:size>',
		'<g:item_group_id>AB12345</g:item_group_id>',
		'<g:product_type>Category</g:product_type>',
		'<g:shipping>10.00 USD</g:shipping>',
		'<g:shipping_label>Only FedEx</g:shipping_label>',
		'</entry>',
		'<entry>',
		'<g:id>001</g:id>',
		'<g:title>Product ABC</g:title>',
		'<g:description>Lorem ipsum dolor sit amet</g:description>',
		'<g:link>http://www.example.com/product-abc/</g:link>',
		'<g:image_link>http://www.example.com/images/product-abc.jpg</g:image_link>',
		'<g:additional_image_link>http://www.example.com/images/product-abc-2.jpg</g:additional_image_link>',
		'<g:additional_image_link>http://www.example.com/images/product-abc-3.jpg</g:additional_image_link>',
		'<g:availability>in stock</g:availability>',
		'<g:price>5.00 USD</g:price>',
		'<g:brand>Brand</g:brand>',
		'<g:identifier_exists>no</g:identifier_exists>',
		'<g:condition>new</g:condition>',
		'<g:adult>no</g:adult>',
		'<g:color>red</g:color>',
		'<g:gender>male</g:gender>',
		'<g:size>XXL</g:size>',
		'<g:item_group_id>AB12345</g:item_group_id>',
		'<g:product_type>Category</g:product_type>',
		'<g:shipping>10.00 USD</g:shipping>',
		'<g:shipping_label>Only FedEx</g:shipping_label>',
		'</entry>',
		'</feed>',
		'',
	]), $output->getOutput());
});
