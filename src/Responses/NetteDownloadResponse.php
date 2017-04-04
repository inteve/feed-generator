<?php

	namespace Inteve\FeedGenerator\Responses;

	use Inteve\FeedGenerator\IFeed;
	use Inteve\FeedGenerator\Outputs;
	use Nette;


	class NetteDownloadResponse implements Nette\Application\IResponse
	{
		/** @var IFeed */
		private $feed;

		/** @var string */
		private $filename;

		/** @var bool */
		private $forceDownload;


		/**
		 * @param  IFeed
		 * @param  string
		 * @param  bool
		 */
		public function __construct(IFeed $feed, $filename, $forceDownload = TRUE)
		{
			$this->feed = $feed;
			$this->filename = $filename;
			$this->forceDownload = $forceDownload;
		}


		/**
		 * Sends response to output.
		 * @return void
		 */
		public function send(Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse)
		{
			$httpResponse->setContentType($this->feed->getContentType());
			$httpResponse->setHeader('Content-Disposition',
				($this->forceDownload ? 'attachment' : 'inline')
					. '; filename="' . $this->filename . '"'
					. '; filename*=utf-8\'\'' . rawurlencode($this->filename));

			$this->feed->generate(new Outputs\DirectOutput);
		}
	}
