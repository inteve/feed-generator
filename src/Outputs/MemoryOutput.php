<?php

	namespace Inteve\FeedGenerator\Outputs;

	use Inteve\FeedGenerator\IOutput;


	class MemoryOutput implements IOutput
	{
		/** @var string */
		private $output = '';


		/**
		 * @return void
		 */
		public function open()
		{
			$this->output = '';
		}


		/**
		 * @param  string
		 * @return void
		 */
		public function output($s)
		{
			$this->output .= $s;
		}


		/**
		 * @return void
		 */
		public function close()
		{
		}


		/**
		 * @return string
		 */
		public function getOutput()
		{
			return $this->output;
		}
	}
