
# Feed Generator


## Installation

[Download a latest package](https://github.com/inteve/feed-generator/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/feed-generator
```

Feed Generator requires PHP 5.3.0 or later and ....


## Usage

``` php
use Inteve\FeedGenerator\GoogleMerchant;

$feed = new GoogleMerchant\GoogleMerchantFeed;
$feed->setTitle('Products');
$feed->setUpdated(new \DateTime);
$feed->setWebsiteUrl('https://www.example.com/');
$feed->setAuthor('My Shop');
$items = array();

foreach ($products as $product) {
	$item = new GoogleMerchant\GoogleMerchantItem;
	$item->setId($product->id)
		->setTitle($product->title)
		->setDescription($product->description)
		->setUrl('https://www.example.com/product/' . $product->url)
		->setImageUrl('https://www.example.com/images/product/' . $product->id)
		->setAvailability($product->qty > 0 ? '' : '')
		->setPrice($product->price, 'USD');
	$items[] = $item;
}

$feed->setItems($items);
$feed->generate(new Inteve\FeedGenerator\Outputs\FileOutput(__DIR__ . '/feeds/google.xml'));
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
