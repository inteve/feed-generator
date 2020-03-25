<?php

	namespace Inteve\FeedGenerator\Feeds\Sitemap;

	use Inteve\FeedGenerator\AssertException;
	use Inteve\FeedGenerator\IFeedItem;
	use Inteve\FeedGenerator\Utils\Helpers;
	use Nette\Utils\Validators;


	class SitemapItem implements IFeedItem
	{

		/** @var string|int|NULL */
		private $location;

		/** @var string|NULL */
		private $lastModified;

		/** @var string|NULL */
		private $priority;


		/**
		 * @return string|int|NULL
		 */
		public function getLocation()
		{
			return $this->location;
		}


		/**
		 * @param  string|int
		 * @return self
		 */
		public function setLocation($location)
		{
			$this->location = $location;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getLastModified()
		{
			return $this->lastModified;
		}


		/**
		 * @param  string
		 * @return self
		 */
		public function setLastModified($lastModified)
		{
			$this->lastModified = $lastModified;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getPriority()
		{
			return $this->priority;
		}


		/**
		 * @param  string
		 * @return self
		 */
		public function setPriority($prioritys)
		{
			$this->priority = $prioritys;
			return $this;
		}

		/**
		 * @return void
		 * @throws AssertException
		 */
		public function validate()
		{
			Helpers::assert(isset($this->location), 'Missing item location, call $item->setLocation().');
			Helpers::assert(isset($this->lastModified), 'Missing item last modified date, call $item->setLastModified().');
			Helpers::assert(isset($this->priority), 'Missing item priority, call $item->setPriority().');
		}


		/**
		 * @return static
		 */
		public static function create()
		{
			return new static;
		}
	}
