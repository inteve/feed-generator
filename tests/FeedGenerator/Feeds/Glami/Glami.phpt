<?php

use Inteve\FeedGenerator\Feeds\Glami\GlamiFeed;
use Inteve\FeedGenerator\Feeds\Glami\GlamiItem;
use Inteve\FeedGenerator\ItemsGroup;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new GlamiFeed;
	$items = [];
	$itemsGroup = new ItemsGroup;

	$groupItem = GlamiItem::create()
		->setId('001')
		->setProductName('Product ABC')
		->setDescription('Lorem ipsum dolor sit amet')
		->setCategoryText('Glami.cz | Oblečení')
		->setUrl('http://www.example.com/product-abc/')
		->setImageUrl('http://www.example.com/images/product-abc.jpg')
		->setPriceVat(5)
		->setDeliveryDate(0)
		->setEan('6417182041488')
		->setGroupId('AB12345')
		->addParameter('barva', 'modrá')
		->addParameter('velikost', 'XXL');

	$itemsGroup->addItem($groupItem);
	$items[] = $itemsGroup;
	$items[] = NULL;

	$items[] = GlamiItem::create()
		->setId('002')
		->setProductName('Product DEF')
		->setCategoryText('Glami.cz | Boty')
		->setUrl('http://www.example.com/product-def/')
		->setImageUrl('http://www.example.com/images/product-def.jpg')
		->setPriceVat(10.10)
		->setDeliveryDate(5)
		->addParameter('velikost', 'XS');

	$feed->setItems($items);
	$feed->generate($output);

	Assert::same('text/xml', $feed->getContentType());

	Assert::same(implode("\n", [
		'<?xml version="1.0" encoding="utf-8"?>',
		'<SHOP>',
		'<SHOPITEM>',
		'<ITEM_ID>001</ITEM_ID>',
		'<EAN>6417182041488</EAN>',
		'<PRODUCTNAME>Product ABC</PRODUCTNAME>',
		'<DESCRIPTION>Lorem ipsum dolor sit amet</DESCRIPTION>',
		'<CATEGORYTEXT>Glami.cz | Oblečení</CATEGORYTEXT>',
		'<URL>http://www.example.com/product-abc/</URL>',
		'<IMGURL>http://www.example.com/images/product-abc.jpg</IMGURL>',
		'<PRICE_VAT>5.00</PRICE_VAT>',
		'<DELIVERY_DATE>0</DELIVERY_DATE>',
		'<ITEMGROUP_ID>AB12345</ITEMGROUP_ID>',
		'<PARAM>',
		'<PARAM_NAME>barva</PARAM_NAME>',
		'<VAL>modrá</VAL>',
		'</PARAM>',
		'<PARAM>',
		'<PARAM_NAME>velikost</PARAM_NAME>',
		'<VAL>XXL</VAL>',
		'</PARAM>',
		'</SHOPITEM>',

		'<SHOPITEM>',
		'<ITEM_ID>002</ITEM_ID>',
		'<PRODUCTNAME>Product DEF</PRODUCTNAME>',
		'<CATEGORYTEXT>Glami.cz | Boty</CATEGORYTEXT>',
		'<URL>http://www.example.com/product-def/</URL>',
		'<IMGURL>http://www.example.com/images/product-def.jpg</IMGURL>',
		'<PRICE_VAT>10.10</PRICE_VAT>',
		'<DELIVERY_DATE>5</DELIVERY_DATE>',
		'<PARAM>',
		'<PARAM_NAME>velikost</PARAM_NAME>',
		'<VAL>XS</VAL>',
		'</PARAM>',
		'</SHOPITEM>',
		'</SHOP>',
		'',
	]), $output->getOutput());
});
