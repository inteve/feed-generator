<?php

	namespace Inteve\FeedGenerator;


	abstract class Feed implements IFeed
	{
		/** @var array|\Traversable */
		protected $items = array();


		/**
		 * @param  array|\Traversable
		 */
		public function setItems($items)
		{
			if (!is_array($items) && !($items instanceof \Traversable)) {
				throw new InvalidArgumentException('Items must be array or \\Traversable, ' . gettype($items) . ' given.');
			}
			$this->items = $items;
			return $this;
		}
	}
