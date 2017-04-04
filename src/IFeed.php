<?php

	namespace Inteve\FeedGenerator;


	interface IFeed
	{
		/**
		 * @param  array|\Traversable
		 */
		function setItems($items);

		/**
		 * @return string
		 */
		function getContentType();

		/**
		 * @return void
		 */
		function generate(IOutput $output);
	}
