<?php

	namespace Inteve\FeedGenerator\Outputs;

	use Inteve\FeedGenerator\FileSystemException;
	use Inteve\FeedGenerator\IOutput;
	use Inteve\FeedGenerator\OutputException;


	class FileOutput implements IOutput
	{
		/** @var string */
		private $file;

		/** @var resource */
		private $fp;

		/** @var bool */
		private $opened = FALSE;


		/**
		 * @param  string
		 */
		public function __construct($file)
		{
			$this->file = $file;
		}


		/**
		 * @return void
		 * @throws FileSystemException
		 */
		public function open()
		{
			if (!$this->opened) {
				@mkdir(dirname($this->file), 0777, TRUE);
				$fp = @fopen($this->file, 'w');

				if ($fp === FALSE) {
					throw new FileSystemException("File '{$this->file}' is not writable.");
				}

				$this->fp = $fp;
				$this->opened = TRUE;
			}
		}


		/**
		 * @param  string
		 * @return void
		 * @throws OutputException
		 */
		public function output($s)
		{
			if (!$this->opened) {
				throw new OutputException("File is not open, call open() method.");
			}
			fwrite($this->fp, $s);
		}


		/**
		 * @return void
		 */
		public function close()
		{
			if ($this->opened) {
				fclose($this->fp);
				$this->opened = FALSE;
			}
		}
	}
