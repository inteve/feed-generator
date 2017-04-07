<?php

use Inteve\FeedGenerator\Feeds\Heureka\HeurekaFeed;
use Inteve\FeedGenerator\Feeds\Heureka\HeurekaItem;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new HeurekaFeed;
	$items = array();

	$items[] = HeurekaItem::create()
		->setId('001')
		->setProductName('Product ABC')
		->setDescription('Lorem ipsum dolor sit amet')
		->setUrl('http://www.example.com/product-abc/')
		->setImageUrl('http://www.example.com/images/product-abc.jpg')
		->setPrice(5)
		->setDeliveryDate(0)
		->setGroupId('AB12345')
		->addParameter('color', 'red')
		->addParameter('size', 'XXL')
		->addParameter('weight', 10, 'kg');

	$items[] = HeurekaItem::create()
		->setId('002')
		->setProductName('Product DEF')
		->setDescription('Lorem ipsum dolor sit amet')
		->setUrl('http://www.example.com/product-def/')
		->setImageUrl('http://www.example.com/images/product-def.jpg')
		->setPrice(10.10)
		->setDeliveryDate(new \DateTime('2016-02-06 18:00:00+0200', new \DateTimeZone('UTC')));

	$feed->setItems($items);
	$feed->generate($output);

	Assert::same('text/xml', $feed->getContentType());

	Assert::same(implode("\n", array(
		'<?xml version="1.0" encoding="utf-8"?>',
		'<SHOP>',
		'<SHOPITEM>',
		'<ITEM_ID>001</ITEM_ID>',
		'<PRODUCTNAME>Product ABC</PRODUCTNAME>',
		'<DESCRIPTION>Lorem ipsum dolor sit amet</DESCRIPTION>',
		'<URL>http://www.example.com/product-abc/</URL>',
		'<IMGURL>http://www.example.com/images/product-abc.jpg</IMGURL>',
		'<PRICE_VAT>5.00</PRICE_VAT>',
		'<DELIVERY_DATE>0</DELIVERY_DATE>',
		'<ITEMGROUP_ID>AB12345</ITEMGROUP_ID>',
		'<PARAM>',
		'<PARAM_NAME>color</PARAM_NAME>',
		'<VAL>red</VAL>',
		'</PARAM>',
		'<PARAM>',
		'<PARAM_NAME>size</PARAM_NAME>',
		'<VAL>XXL</VAL>',
		'</PARAM>',
		'<PARAM>',
		'<PARAM_NAME>weight</PARAM_NAME>',
		'<VAL>10kg</VAL>',
		'</PARAM>',
		'</SHOPITEM>',

		'<SHOPITEM>',
		'<ITEM_ID>002</ITEM_ID>',
		'<PRODUCTNAME>Product DEF</PRODUCTNAME>',
		'<DESCRIPTION>Lorem ipsum dolor sit amet</DESCRIPTION>',
		'<URL>http://www.example.com/product-def/</URL>',
		'<IMGURL>http://www.example.com/images/product-def.jpg</IMGURL>',
		'<PRICE_VAT>10.10</PRICE_VAT>',
		'<DELIVERY_DATE>2016-02-06</DELIVERY_DATE>',
		'</SHOPITEM>',
		'</SHOP>',
		'',
	)), $output->getOutput());
});
