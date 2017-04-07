<?php

	namespace Inteve\FeedGenerator\Feeds\Heureka;

	use Inteve\FeedGenerator\AssertException;
	use Inteve\FeedGenerator\IFeedItem;
	use Inteve\FeedGenerator\InvalidArgumentException;
	use Inteve\FeedGenerator\Utils\Helpers;
	use Nette\Utils\Validators;


	class HeurekaItemParameter implements IFeedItem
	{
		/** @var string */
		private $name;

		/** @var string */
		private $value;

		/** @var string|NULL */
		private $unit;


		/**
		 * @param  string
		 * @param  string
		 * @param  string|NULL
		 */
		public function __construct($name, $value, $unit = NULL)
		{
			$this->name = $name;
			$this->value = $value;
			$this->unit = $unit;
		}


		/**
		 * @return string
		 */
		public function getName()
		{
			return $this->name;
		}


		/**
		 * @return string
		 */
		public function getValue()
		{
			return $this->value;
		}


		/**
		 * @return string|NULL
		 */
		public function getUnit()
		{
			return $this->unit;
		}
	}
