
# Feed Generator

[![Build Status](https://travis-ci.org/inteve/feed-generator.svg?branch=master)](https://travis-ci.org/inteve/feed-generator)

<a href="https://www.patreon.com/bePatron?u=9680759"><img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" alt="Become a Patron!" height="35"></a>
<a href="https://www.paypal.me/janpecha/1eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>


## Installation

[Download a latest package](https://github.com/inteve/feed-generator/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/feed-generator
```

Feed Generator requires PHP 5.6.0 or later.


## Usage

* Feeds
	* [Google Merchant](#google-merchant)
	* [Glami.cz](#glamicz)
	* [Heureka.cz](#heurekacz)
	* [Zbozi.cz](#zbozicz)

* Outputs
	* [FileOutput](#fileoutput)
	* [DirectOutput](#directoutput)
	* [MemoryOutput](#memoryoutput)

* Integrations
	* [Nette](#nette)


### Feeds

#### Google Merchant

``` php
use Inteve\FeedGenerator\Feeds\GoogleMerchant;

$feed = new GoogleMerchant\GoogleMerchantFeed;
$feed->setTitle('Products');
$feed->setWebsiteUrl('http://www.example.com/');
$feed->setUpdated(new DateTime('2017-01-01 00:00:00 UTC'));
$feed->setAuthor('Example.com');
$items = array();

foreach ($products as $product) {
	$item = new GoogleMerchant\GoogleMerchantItem;
	$item->setId($product->id)
		->setTitle($product->title)
		->setDescription($product->description)
		->setUrl('https://www.example.com/product/' . $product->url)
		->setImageUrl('https://www.example.com/images/product/' . $product->id)
		->setAvailability($product->qty > 0 ? $item::AVAILABILITY_IN_STOCK : $item::AVAILABILITY_OUT_OF_STOCK)
		->setPrice($product->price, 'USD');
	$items[] = $item;
}

$feed->setItems($items);
$feed->generate(new Inteve\FeedGenerator\Outputs\FileOutput(__DIR__ . '/feeds/google.xml'));
```


#### Glami.cz

``` php
use Inteve\FeedGenerator\Feeds\Glami;

$feed = new Glami\GlamiFeed;
$items = array();

foreach ($products as $product) {
	$items[] = Glami\GlamiItem::create()
		->setId($product->id)
		->setProductName($product->name)
		->setDescription($product->description)
		->setCategoryText($product->categoryName)
		->setUrl('http://www.example.com/product/' . $product->url)
		->setImageUrl('https://www.example.com/images/product/' . $product->id)
		->setPriceVat($product->price)
		->setDeliveryDate($product->qty > 0 ? 0 : 10) // number of days
		->addParameter('velikost', 'XS');
}

$feed->setItems($items);
$feed->generate(new Inteve\FeedGenerator\Outputs\FileOutput(__DIR__ . '/feeds/glami.xml'));
```


#### Heureka.cz

``` php
use Inteve\FeedGenerator\Feeds\Heureka;

$feed = new Heureka\HeurekaFeed;
$items = array();

foreach ($products as $product) {
	$items[] = Heureka\HeurekaItem::create()
		->setId($product->id)
		->setProductName($product->name)
		->setDescription($product->description)
		->setCategoryText($product->categoryName)
		->setUrl('http://www.example.com/product/' . $product->url)
		->setImageUrl('https://www.example.com/images/product/' . $product->id)
		->setPrice($product->price)
		->setDeliveryDate($product->qty > 0 ? 0 : 10); // number of days or DateTime
}

$feed->setItems($items);
$feed->generate(new Inteve\FeedGenerator\Outputs\FileOutput(__DIR__ . '/feeds/heureka.xml'));
```


#### Zbozi.cz

``` php
use Inteve\FeedGenerator\Feeds\Zbozi;

$feed = new Zbozi\ZboziFeed;
$items = array();

foreach ($products as $product) {
	$items[] = Zbozi\ZboziItem::create()
		->setId($product->id)
		->setProductName($product->name)
		->setDescription($product->description)
		->setUrl('http://www.example.com/product/' . $product->url)
		->setImageUrl('https://www.example.com/images/product/' . $product->id)
		->setPrice($product->price)
		->setDeliveryDate($product->qty > 0 ? 0 : 10); // number of days or DateTime
}

$feed->setItems($items);
$feed->generate(new Inteve\FeedGenerator\Outputs\FileOutput(__DIR__ . '/feeds/zbozi.xml'));
```


### Outputs

#### FileOutput

Sends output to file.

``` php
$output = new Inteve\FeedGenerator\Outputs\FileOutput('/path/to/destination/feed.xml');
$feed->generate($output);
```


#### DirectOutput

Sends output to STDIN.

``` php
$output = new Inteve\FeedGenerator\Outputs\DirectOutput;
$feed->generate($output);
```


#### MemoryOutput

Saves output in memory.

``` php
$output = new Inteve\FeedGenerator\Outputs\MemoryOutput;
$feed->generate($output);
echo $output->getOutput();
```


### Integrations

#### [Nette](https://nette.org/)

Requires package [`nette/application`](https://packagist.org/packages/nette/application).

``` php
$response = new FeedGenerator\Responses\NetteDownloadResponse($feed, 'filename');
$presenter->sendResponse($response);
```

For example:

``` php
class FeedPresenter extends Nette\Application\UI\Presenter
{
	public function actionGoogle()
	{
		$feed = new FeedGenerator\Feeds\GoogleMerchant\GoogleMerchantFeed;
		// prepare feed & items

		$response = new FeedGenerator\Responses\NetteDownloadResponse($feed, 'google.xml');
		$this->sendResponse($response);
	}
}
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
