<?php

	namespace Inteve\FeedGenerator\Feeds\GoogleMerchant;

	use Inteve\FeedGenerator\AssertException;
	use Inteve\FeedGenerator\IFeedItem;
	use Inteve\FeedGenerator\InvalidArgumentException;
	use Inteve\FeedGenerator\Utils\Helpers;


	class GoogleMerchantItem implements IFeedItem
	{
		const AVAILABILITY_IN_STOCK = 'in stock';
		const AVAILABILITY_OUT_OF_STOCK = 'out of stock';
		const AVAILABILITY_PREORDER = 'preorder';

		const CONDITION_NEW = 'new';
		const CONDITION_REFURBISHED = 'refurbished';
		const CONDITION_USED = 'used';

		const GENDER_MALE = 'male';
		const GENDER_FEMALE = 'female';
		const GENDER_UNISEX = 'unisex';

		/** @var string|int */
		private $id;

		/** @var string */
		private $title;

		/** @var string */
		private $description;

		/** @var string|NULL */
		private $url;

		/** @var string|NULL */
		private $imageUrl;

		/** @var string */
		private $availability = self::AVAILABILITY_IN_STOCK;

		/** @var string|NULL */
		private $price;

		/** @var string */
		private $condition = self::CONDITION_NEW;

		/** @var bool */
		private $adult = FALSE;

		/** @var string|NULL */
		private $color;

		/** @var string|NULL */
		private $gender;

		/** @var string|NULL */
		private $size;

		/** @var string|NULL */
		private $groupId;

		/** @var string|NULL */
		private $shipping;

		/** @var string|NULL */
		private $shippingLabel;

		/** @var string|NULL */
		private $brand;

        /** @var int|NULL */
		private $gtin;

		/** @var string|NULL */
		private $mpn;

		/**
		 * @return string|int
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
		 * @return string
		 */
		public function getTitle()
		{
			return $this->title;
		}


		/**
		 * @param  string|int
		 * @return static
		 */
		public function setTitle($title)
		{
			$this->title = $title;
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
		 * @param  string|NULL
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
		 * @param  string|NULL
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
		public function getImageUrl()
		{
			return $this->imageUrl;
		}


		/**
		 * @param  string|NULL
		 * @return static
		 */
		public function setImageUrl($imageUrl)
		{
			$this->imageUrl = $imageUrl;
			return $this;
		}


		/**
		 * @return string
		 */
		public function getAvailability()
		{
			return $this->availability;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setAvailability($availability)
		{
			if (!in_array($availability, [self::AVAILABILITY_IN_STOCK, self::AVAILABILITY_OUT_OF_STOCK, self::AVAILABILITY_PREORDER], TRUE)) {
				throw new InvalidArgumentException("Invalid availability '{$availability}'.");
			}
			$this->availability = $availability;
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
		 * @param  float|string|int
		 * @param  string
		 * @return static
		 */
		public function setPrice($price, $currency)
		{
			$this->price = $this->formatPrice($price, $currency);
			return $this;
		}


		/**
		 * @return string
		 */
		public function getCondition()
		{
			return $this->condition;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setCondition($condition)
		{
			if (!in_array($condition, [self::CONDITION_NEW, self::CONDITION_REFURBISHED, self::CONDITION_USED], TRUE)) {
				throw new InvalidArgumentException("Invalid condition '{$condition}'.");
			}

			$this->condition = $condition;
			return $this;
		}


		/**
		 * @return bool
		 */
		public function isAdult()
		{
			return $this->adult;
		}


		/**
		 * @param  bool
		 * @return static
		 */
		public function setAdult($adult)
		{
			$this->adult = $adult;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getColor()
		{
			return $this->color;
		}


		/**
		 * @param  string|NULL
		 * @return static
		 */
		public function setColor($color)
		{
			$this->color = $color;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getGender()
		{
			return $this->gender;
		}


		/**
		 * @param  string|NULL
		 * @return static
		 */
		public function setGender($gender)
		{
			$this->gender = $gender;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getSize()
		{
			return $this->size;
		}


		/**
		 * @param  string|NULL
		 * @return static
		 */
		public function setSize($size)
		{
			$this->size = $size;
			return $this;
		}


		/**
		 * @return string
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
		 * @return string|NULL
		 */
		public function getShipping()
		{
			return $this->shipping;
		}


		/**
		 * @param string
         * @param string
		 * @return static
		 */
		public function setShipping($price, $currency)
		{
			$this->shipping = $this->formatPrice($price, $currency);
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getShippingLabel()
		{
			return $this->shippingLabel;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public function setShippingLabel($shippingLabel)
		{
			$this->shippingLabel = $shippingLabel;
			return $this;
		}


        /**
         * @return string|NULL
         */
		public function getBrand()
        {
            return $this->brand;
        }


        /**
         * @param string|NULL $brand
         * @return $this
         */
        public function setBrand($brand)
        {
            $this->brand = $brand;
            return $this;
        }


        /**
         * @return int|NULL
         */
        public function getGtin()
        {
            return $this->gtin;
        }


        /**
         * @param int|NULL $gtin
         * @return $this
         */
        public function setGtin($gtin)
        {
            $this->gtin = $gtin;
            return $this;
        }


        /**
         * @return string|NULL
         */
        public function getMpn()
        {
            return $this->mpn;
        }


        /**
         * @param string|NULL $mpn
         * @return $this
         */
        public function setMpn($mpn)
        {
            $this->mpn = $mpn;
            return $this;
        }


		/**
		 * @return bool
		 */
		public function hasIdentifiers()
		{
            return $this->getGtin() !== NULL;
		}


		/**
		 * @return void
		 * @throws AssertException
		 */
		public function validate()
		{
			Helpers::assert(isset($this->id), 'Missing item ID, call $item->setId().');
			Helpers::assert(isset($this->title), 'Missing item title, call $item->setTitle().');
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
		protected function formatPrice($price, $currency)
		{
			return number_format($price, 2, '.', '') . ' ' . $currency;
		}


		/**
		 * @return static
		 */
		public static function create()
		{
			return new static;
		}
	}
