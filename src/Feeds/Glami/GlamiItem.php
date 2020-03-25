<?php

	namespace Inteve\FeedGenerator\Feeds\Glami;

	use Inteve\FeedGenerator\AssertException;
	use Inteve\FeedGenerator\IFeedItem;
	use Inteve\FeedGenerator\InvalidArgumentException;
	use Inteve\FeedGenerator\Utils\Helpers;
	use Nette\Utils\Validators;


	class GlamiItem implements IFeedItem
	{
		/** @var string|int|NULL */
		private $id;

		/** @var string|NULL */
		private $productName;

		/** @var string|NULL */
		private $description;

		/** @var string|NULL */
		private $categoryText;

		/** @var string|NULL */
		private $url;

		/** @var string|int|NULL */
		private $ean;

		/** @var string|NULL */
		private $priceVat;

		/** @var string|NULL */
		private $deliveryDate;

		/** @var GlamiItemParameter[] */
		private $parameters = array();

		/** @var string|NULL */
		private $imageUrl;

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
		 * @return string|int|NULL
		 */
		public function getEan()
		{
			return $this->ean;
		}


		/**
		 * @param  string|int
		 * @return static
		 */
		public function setEan($ean)
		{
			$this->ean = $ean;
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
		 * @param  string|int
		 * @return static
		 */
		public function setDeliveryDate($deliveryDate)
		{
			$this->deliveryDate = $deliveryDate;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getPriceVat()
		{
			return $this->priceVat;
		}


		/**
		 * @param  string|float|int
		 * @return static
		 */
		public function setPriceVat($priceVat)
		{
			$this->priceVat = $this->formatPrice($priceVat);
			return $this;
		}


		/**
		 * @return GlamiItemParameter[]
		 */
		public function getParameters()
		{
			return $this->parameters;
		}


		/**
		 * @param  string
		 * @param  string
		 * @param  number|NULL
		 * @return static
		 */
		public function addParameter($name, $value, $percentage = NULL)
		{
			$this->parameters[] = new GlamiItemParameter($name, $value, $percentage);
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
		 * @param  string
		 * @return GlamiItemParameter|NULL
		 */
		public function getParameter($name)
		{
			foreach ($this->parameters as $parameter) {
				if ($parameter->getName() === $name) {
					return $parameter;
				}
			}

			return NULL;
		}


		/**
		 * @return void
		 * @throws AssertException
		 */
		public function validate()
		{
			Helpers::assert(isset($this->id), 'Missing item ID, call $item->setId().');
			Helpers::assert(isset($this->productName), 'Missing item product name, call $item->setProductName().');
			Helpers::assert(isset($this->url), 'Missing item URL, call $item->setUrl().');
			Helpers::assert(isset($this->imageUrl), 'Missing item image URL, call $item->setImageUrl().');
			Helpers::assert(isset($this->priceVat), 'Missing item priceVat, call $item->setPriceVat().');
			Helpers::assert(isset($this->categoryText), 'Missing item category text, call $item->setCategoryText().');
			Helpers::assert(isset($this->deliveryDate), 'Missing item delivery date, call $item->setDeliveryDate().');

			$size = $this->getParameter('velikost');
			Helpers::assert($size !== NULL, 'Missing item size, call $item->setParameter(\'velikost\', $size).');
			Helpers::assert($size->hasValue(), 'Item size has no value, call $item->setParameter(\'velikost\', $size).');
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
