<?php

	namespace Inteve\FeedGenerator;


	class ItemsGroup
	{
		/** @var IFeedItem[] */
		protected $items = [];


		/**
		 * @return IFeedItem[]
		 */
		public function getItems()
		{
			return $this->items;
		}


		/**
		 * @return static
		 */
		public function addItem(IFeedItem $item)
		{
			$this->items[] = $item;
			return $this;
		}
	}
