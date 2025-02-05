<?php

	namespace Inteve\FeedGenerator\Feeds\Zbozi;

	use Inteve\FeedGenerator\AssertException;
	use Inteve\FeedGenerator\IFeedItem;
	use Inteve\FeedGenerator\InvalidArgumentException;
	use Inteve\FeedGenerator\Utils\Helpers;
	use Nette\Utils\Validators;


	class ZboziItem implements IFeedItem
	{
		const DELIVERY_DATE_UNKNOW = -1;

		/** @var string|int|NULL */
		private $id;

		/** @var string|NULL */
		private $productName;

		/** @var string|NULL */
		private $product;

		/** @var string|NULL */
		private $description;

		/** @var string|NULL */
		private $url;

		/** @var string|NULL */
		private $price;

		/** @var string|NULL */
		private $priceBeforeDiscount;

		/** @var string|NULL */
		private $deliveryDate;

		/** @var ZboziItemParameter[] */
		private $parameters = [];

		/** @var string|NULL */
		private $imageUrl;

		/** @var string[] */
		private $alternativeImageUrls = [];

		/** @var string|NULL */
		private $categoryText;

		/** @var array<int, string> */
		private $customLabels;

		/** @var string|NULL */
		private $groupId;


		/**
		 * @return string|int|NULL
		 */
		public function getId()
		{
			return $this->id;
		}


		/**
		 * @param  string|int
		 * @return static
		 */
		public function setId($id)
		{
			$this->id = $id;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getProductName()
		{
			return $this->productName;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setProductName($productName)
		{
			$this->productName = $productName;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getProduct()
		{
			return $this->product;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setProduct($product)
		{
			$this->product = $product;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getDescription()
		{
			return $this->description;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setDescription($description)
		{
			$this->description = $description;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getUrl()
		{
			return $this->url;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setUrl($url)
		{
			$this->url = $url;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getDeliveryDate()
		{
			return $this->deliveryDate;
		}


		/**
		 * @param  string|\DateTimeInterface|int
		 * @return static
		 */
		public function setDeliveryDate($deliveryDate)
		{
			if ($deliveryDate instanceof \DateTimeInterface) {
				$this->deliveryDate = $deliveryDate->format('Y-m-d');

			} else {
				$this->deliveryDate = $deliveryDate;
			}
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getPrice()
		{
			return $this->price;
		}


		/**
		 * @param  string|float|int
		 * @return static
		 */
		public function setPrice($price)
		{
			$this->price = $this->formatPrice($price);
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getPriceBeforeDiscount()
		{
			return $this->priceBeforeDiscount;
		}


		/**
		 * @param  string|float|int|NULL
		 * @return static
		 */
		public function setPriceBeforeDiscount($priceBeforeDiscount)
		{
			$this->priceBeforeDiscount = $this->formatPrice($priceBeforeDiscount);
			return $this;
		}


		/**
		 * @return ZboziItemParameter[]
		 */
		public function getParameters()
		{
			return $this->parameters;
		}


		/**
		 * @param  string
		 * @param  string
		 * @param  string|NULL
		 * @return static
		 */
		public function addParameter($name, $value, $unit = NULL)
		{
			$this->parameters[] = new ZboziItemParameter($name, $value, $unit);
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getImageUrl()
		{
			return $this->imageUrl;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setImageUrl($imageUrl)
		{
			$this->imageUrl = $imageUrl;
			return $this;
		}


		/**
		 * @return string[]
		 */
		public function getAlternativeImageUrls()
		{
			return $this->alternativeImageUrls;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function addAlternativeImageUrl($alternativeImageUrl)
		{
			$this->alternativeImageUrls[] = $alternativeImageUrl;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getCategoryText()
		{
			return $this->categoryText;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setCategoryText($categoryText)
		{
			$this->categoryText = $categoryText;
			return $this;
		}


		/**
		 * @param  int
		 * @return string|NULL
		 */
		public function getCustomLabel($id)
		{
			return isset($this->customLabels[$id]) ? $this->customLabels[$id] : NULL;
		}


		/**
		 * @param  int
		 * @param  string
		 * @return static
		 */
		public function setCustomLabel($id, $value)
		{
			$this->customLabels[$id] = $value;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getGroupId()
		{
			return $this->groupId;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setGroupId($groupId)
		{
			$this->groupId = $groupId;
			return $this;
		}


		/**
		 * @return void
		 * @throws AssertException
		 */
		public function validate()
		{
			Helpers::assert(isset($this->productName), 'Missing item product name, call $item->setProductName().');
			Helpers::assert(isset($this->description), 'Missing item description, call $item->setDescription().');
			Helpers::assert(isset($this->url), 'Missing item URL, call $item->setUrl().');
			Helpers::assert(isset($this->imageUrl), 'Missing item image URL, call $item->setImageUrl().');
			Helpers::assert(isset($this->price), 'Missing item price, call $item->setPrice().');
		}


		/**
		 * @param  string|float|int
		 * @param  string
		 * @return string
		 */
		protected function formatPrice($price)
		{
			return number_format($price, 2, '.', '');
		}


		/**
		 * @return static
		 */
		public static function create()
		{
			return new static;
		}
	}
