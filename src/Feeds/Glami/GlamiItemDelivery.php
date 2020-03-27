<?php

	namespace Inteve\FeedGenerator\Feeds\Glami;


	class GlamiItemDelivery
	{
		/** @var string */
		private $id;

		/** @var string */
		private $price;

		/** @var string|NULL */
		private $priceCod;


		/**
		 * @param  string
		 * @param  string|float|int
		 * @param  string|float|int|NULL
		 */
		public function __construct($id, $price, $priceCod)
		{
			$this->id = $id;
			$this->price = GlamiItem::formatPriceInt($price);
			$this->priceCod = $priceCod !== NULL ? GlamiItem::formatPriceInt($priceCod) : NULL;
		}


		/**
		 * @return string
		 */
		public function getId()
		{
			return $this->id;
		}


		/**
		 * @return string
		 */
		public function getPrice()
		{
			return $this->price;
		}


		/**
		 * @return string|NULL
		 */
		public function getPriceCod()
		{
			return $this->priceCod;
		}
	}
