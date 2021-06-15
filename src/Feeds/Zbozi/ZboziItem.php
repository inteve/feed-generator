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
		private $description;

		/** @var string|NULL */
		private $url;

		/** @var string|NULL */
		private $ean;

		/** @var string|NULL */
		private $price;

		/** @var string|NULL */
		private $listPrice;

		/** @var string|NULL */
		private $deliveryDate;

		/** @var ZboziItemParameter[] */
		private $parameters = array();

		/** @var string|NULL */
		private $imageUrl;

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
		 * @return self
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
		 * @return self
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
		 * @return self
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
		 * @return self
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
		 * @return self
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
		 * @return string|NULL
		 */
		public function getListPrice()
		{
			return $this->listPrice;
		}

		/**
		 * @param  string|float|int
		 * @return self
		 */
		public function setListPrice($price)
		{
			$this->listPrice = $this->formatPrice($price);
			return $this;
		}


		/**
		 * @param  string|float|int
		 * @return self
		 */
		public function setPrice($price)
		{
			$this->price = $this->formatPrice($price);
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
		 * @return self
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
		 * @return self
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
		 * @return self
		 */
		public function setGroupId($groupId)
		{
			$this->groupId = $groupId;
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
		 * @return self
		 */
		public function setEan($ean)
		{
			$this->ean = $ean;
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
