<?php

	namespace Inteve\FeedGenerator\Feeds\PostFeed;

	use Inteve\FeedGenerator\IFeedItem;


	class PostFeedItem implements IFeedItem
	{
		/** @var string|int */
		private $id;

		/** @var string */
		private $title;

		/** @var \DateTime */
		private $date;

		/** @var string|NULL */
		private $text;

		/** @var string|NULL */
		private $url;

		/** @var string|NULL */
		private $image;


		/**
		 * @param  string|int
		 * @param  string
		 * @param  \DateTime
		 */
		public function __construct($id, $title, \DateTime $date)
		{
			$this->id = $id;
			$this->title = $title;
			$this->date = $date;
		}


		/**
		 * @return string|int
		 */
		public function getId()
		{
			return $this->id;
		}


		/**
		 * @return string
		 */
		public function getTitle()
		{
			return $this->title;
		}


		/**
		 * @return \DateTime
		 */
		public function getDate()
		{
			return $this->date;
		}


		/**
		 * @return string|NULL
		 */
		public function getText()
		{
			return $this->text;
		}


		/**
		 * @param  string|NULL
		 * @return self
		 */
		public function setText($text)
		{
			$this->text = $text;
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
		public function getImage()
		{
			return $this->image;
		}


		/**
		 * @param  string|NULL
		 * @return self
		 */
		public function setImage($image)
		{
			$this->image = $image;
			return $this;
		}


		/**
		 * @param  string|int
		 * @param  string
		 * @param  \DateTime
		 * @return static
		 */
		public static function create($id, $title, \DateTime $date)
		{
			return new static($id, $title, $date);
		}
	}
