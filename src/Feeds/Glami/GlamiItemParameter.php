<?php

	namespace Inteve\FeedGenerator\Feeds\Glami;

	use Inteve\FeedGenerator\AssertException;
	use Inteve\FeedGenerator\IFeedItem;
	use Inteve\FeedGenerator\InvalidArgumentException;
	use Inteve\FeedGenerator\Utils\Helpers;
	use Nette\Utils\Validators;


	class GlamiItemParameter
	{
		/** @var string */
		private $name;

		/** @var string|NULL */
		private $value;

		/** @var string|NULL */
		private $percentage;


		/**
		 * @param  string
		 * @param  string|NULL
		 * @param  string|NULL
		 */
		public function __construct($name, $value, $percentage)
		{
			$this->name = $name;
			$this->value = $value;
			$this->percentage = $percentage;

			if ($this->percentage !== NULL && substr($this->percentage, -1) !== '%') {
				$this->percentage .= '%';
			}
		}


		/**
		 * @return bool
		 */
		public function isFilled()
		{
			return $this->value !== NULL || $this->percentage !== NULL;
		}


		/**
		 * @return string
		 */
		public function getName()
		{
			return $this->name;
		}


		/**
		 * @return string|NULL
		 */
		public function getValue()
		{
			return $this->value;
		}


		/**
		 * @return bool
		 */
		public function hasValue()
		{
			return $this->value !== NULL;
		}


		/**
		 * @return string|NULL
		 */
		public function getPercentage()
		{
			return $this->percentage;
		}


		/**
		 * @return bool
		 */
		public function hasPercentage()
		{
			return $this->percentage !== NULL;
		}
	}
