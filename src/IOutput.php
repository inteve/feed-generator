<?php

	namespace Inteve\FeedGenerator;


	interface IOutput
	{
		/**
		 * @return void
		 */
		function open();

		/**
		 * @param  string
		 * @return void
		 */
		function output($s);

		/**
		 * @return void
		 */
		function close();
	}
