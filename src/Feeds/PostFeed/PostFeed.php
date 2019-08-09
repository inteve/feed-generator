<?php

	namespace Inteve\FeedGenerator\Feeds\PostFeed;

	use Inteve\FeedGenerator\Feed;
	use Inteve\FeedGenerator\IOutput;
	use Inteve\FeedGenerator\InvalidItemException;
	use Nette\Utils\Json;


	class PostFeed extends Feed
	{
		/**
		 * @return string
		 */
		public function getContentType()
		{
			return 'application/json';
		}


		/**
		 * @return void
		 * @throws InvalidItemException
		 */
		public function generate(IOutput $output)
		{
			$output->open();
			$output->output('[');
			$skipSeparator = TRUE;
			$timezone = new \DateTimezone('UTC');

			foreach ($this->items as $item) {
				if (!($item instanceof PostFeedItem)) {
					throw new InvalidItemException('Feed item must be instance of PostFeedItem.');
				}

				if ($skipSeparator) {
					$skipSeparator = FALSE;

				} else {
					$output->output(',');
				}

				$output->output("\n");
				$date = clone $item->getDate();
				$date->setTimezone($timezone);

				$data = array(
					'id' => $item->getId(),
					'title' => $item->getTitle(),
					'date' => $date->format('Y-m-d H:i:s'),
					'text' => $item->getText(),
					'url' => $item->getUrl(),
					'image' => $item->getImage(),
					'meta' => $item->getMeta(),
				);

				if ($data['text'] === NULL) {
					unset($data['text']);
				}

				if ($data['url'] === NULL) {
					unset($data['url']);
				}

				if ($data['image'] === NULL) {
					unset($data['image']);
				}

				if ($data['meta'] === NULL) {
					unset($data['meta']);
				}

				$output->output(Json::encode($data));
			}

			$output->output("\n]\n");
			$output->close();
		}
	}
