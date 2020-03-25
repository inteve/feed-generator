<?php

	namespace Inteve\FeedGenerator\Feeds\Sitemap;

	use Inteve\FeedGenerator\Feed;
	use Inteve\FeedGenerator\InvalidItemException;
	use Inteve\FeedGenerator\IOutput;
	use Inteve\FeedGenerator\Utils\Helpers;


	class SitemapFeed extends Feed
	{
		/**
		 * @return string
		 */
		public function getContentType()
		{
			return 'text/xml';
		}


		/**
		 * @return void
		 * @throws InvalidItemException
		 */
		public function generate(IOutput $output)
		{
			$output->open();
			$output->output('<?xml version="1.0" encoding="utf-8"?>');
			$output->output("\n");
			$output->output('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">');
			$output->output("\n");

			foreach ($this->items as $item) {
				if (!($item instanceof SitemapItem)) {
					throw new InvalidItemException('Feed item must be instance of SitemapItem.');
				}

				$item->validate();

				$output->output("<url>\n");

				Helpers::writeXml($output, array(
					'loc' => $item->getLocation(),
					'lastmod' => $item->getLastModified(),
					'priority' => $item->getPriority()
				));

				$output->output("</url>\n");
			}

			$output->output('</urlset>');
			$output->output("\n");
			$output->close();
		}
	}
