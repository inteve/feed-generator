<?php

use Inteve\FeedGenerator\Feeds\Zbozi\ZboziFeed;
use Inteve\FeedGenerator\Feeds\Zbozi\ZboziItem;
use Inteve\FeedGenerator\Feeds\Zbozi\ZboziItemExtraMessage;
use Inteve\FeedGenerator\ItemsGroup;
use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Nette\Utils\Json;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	$feed = new ZboziFeed;
	$items = [];
	$itemsGroup = new ItemsGroup;

	$groupItem = ZboziItem::create()
		->setId('001')
		->setProductName('Product ABC')
		->setDescription('Lorem ipsum dolor sit amet')
		->setUrl('http://www.example.com/product-abc/')
		->setImageUrl('http://www.example.com/images/product-abc.jpg')
		->addAlternativeImageUrl('http://www.example.com/images/product-abc-2.jpg')
		->addAlternativeImageUrl('http://www.example.com/images/product-abc-3.jpg')
		->setPrice(5)
		->setDeliveryDate(0)
		->setGroupId('AB12345')
		->addParameter('color', 'red')
		->addParameter('size', 'XXL')
		->addParameter('weight', 10, 'kg');

	$itemsGroup->addItem($groupItem);
	$itemsGroup->addItem($groupItem);
	$items[] = $itemsGroup;
	$items[] = NULL;

	$items[] = ZboziItem::create()
		->setId('002')
		->setProductName('Product DEF')
		->setProduct('Product DEF Lorem ipsum')
		->setDescription('Lorem ipsum dolor sit amet')
		->setUrl('http://www.example.com/product-def/')
		->setImageUrl('http://www.example.com/images/product-def.jpg')
		->setCategoryText('Foto | Fotoaparáty a videokamery | Blesky')
		->setCustomLabel(0, 'Letni akce')
		->setCustomLabel(1, 'Vysoká prodejnost')
		->setCustomLabel(3, 'Výprodej')
		->addExtraMessage(ZboziItemExtraMessage::Custom, 'My custom text')
		->addExtraMessage(ZboziItemExtraMessage::PayLater)
		->setPrice(10.10)
		->setPriceBeforeDiscount(20.10)
		->setDeliveryDate(new \DateTimeImmutable('2016-02-06 18:00:00+0200', new \DateTimeZone('UTC')));

	$feed->setItems($items);
	$feed->generate($output);

	Assert::same('text/xml', $feed->getContentType());

	Assert::same(implode("\n", [
		'<?xml version="1.0" encoding="utf-8"?>',
		'<SHOP xmlns="http://www.zbozi.cz/ns/offer/1.0">',
		'<SHOPITEM>',
		'<ITEM_ID>001</ITEM_ID>',
		'<PRODUCTNAME>Product ABC</PRODUCTNAME>',
		'<DESCRIPTION>Lorem ipsum dolor sit amet</DESCRIPTION>',
		'<URL>http://www.example.com/product-abc/</URL>',
		'<IMGURL>http://www.example.com/images/product-abc.jpg</IMGURL>',
		'<IMGURL_ALTERNATIVE>http://www.example.com/images/product-abc-2.jpg</IMGURL_ALTERNATIVE>',
		'<IMGURL_ALTERNATIVE>http://www.example.com/images/product-abc-3.jpg</IMGURL_ALTERNATIVE>',
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
		'<VAL>10</VAL>',
		'<UNIT>kg</UNIT>',
		'</PARAM>',
		'</SHOPITEM>',

		'<SHOPITEM>',
		'<ITEM_ID>001</ITEM_ID>',
		'<PRODUCTNAME>Product ABC</PRODUCTNAME>',
		'<DESCRIPTION>Lorem ipsum dolor sit amet</DESCRIPTION>',
		'<URL>http://www.example.com/product-abc/</URL>',
		'<IMGURL>http://www.example.com/images/product-abc.jpg</IMGURL>',
		'<IMGURL_ALTERNATIVE>http://www.example.com/images/product-abc-2.jpg</IMGURL_ALTERNATIVE>',
		'<IMGURL_ALTERNATIVE>http://www.example.com/images/product-abc-3.jpg</IMGURL_ALTERNATIVE>',
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
		'<VAL>10</VAL>',
		'<UNIT>kg</UNIT>',
		'</PARAM>',
		'</SHOPITEM>',

		'<SHOPITEM>',
		'<ITEM_ID>002</ITEM_ID>',
		'<PRODUCTNAME>Product DEF</PRODUCTNAME>',
		'<PRODUCT>Product DEF Lorem ipsum</PRODUCT>',
		'<DESCRIPTION>Lorem ipsum dolor sit amet</DESCRIPTION>',
		'<URL>http://www.example.com/product-def/</URL>',
		'<IMGURL>http://www.example.com/images/product-def.jpg</IMGURL>',
		'<CATEGORYTEXT>Foto | Fotoaparáty a videokamery | Blesky</CATEGORYTEXT>',
		'<CUSTOM_LABEL_0>Letni akce</CUSTOM_LABEL_0>',
		'<CUSTOM_LABEL_1>Vysoká prodejnost</CUSTOM_LABEL_1>',
		'<CUSTOM_LABEL_3>Výprodej</CUSTOM_LABEL_3>',
		'<PRICE_VAT>10.10</PRICE_VAT>',
		'<PRICE_BEFORE_DISCOUNT>20.10</PRICE_BEFORE_DISCOUNT>',
		'<DELIVERY_DATE>2016-02-06</DELIVERY_DATE>',
		'<EXTRA_MESSAGE>custom</EXTRA_MESSAGE>',
		'<CUSTOM_TEXT>My custom text</CUSTOM_TEXT>',
		'<EXTRA_MESSAGE>pay_later</EXTRA_MESSAGE>',
		'</SHOPITEM>',
		'</SHOP>',
		'',
	]), $output->getOutput());
});
