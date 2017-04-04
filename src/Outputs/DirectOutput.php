<?php

	namespace Inteve\FeedGenerator\Outputs;

	use Inteve\FeedGenerator\IOutput;


	class DirectOutput implements IOutput
	{
		/**
		 * @return void
		 */
		public function open()
		{
		}


		/**
		 * @param  string
		 * @return void
		 */
		public function output($s)
		{
			echo $s;
		}


		/**
		 * @return void
		 */
		public function close()
		{
		}
	}
