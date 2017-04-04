
# Feed Generator


## Installation

[Download a latest package](https://github.com/inteve/feed-generator/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/feed-generator
```

Feed Generator requires PHP 5.3.0 or later.


## Usage

* Feeds
	* [Google Merchant](#google-merchant)

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
