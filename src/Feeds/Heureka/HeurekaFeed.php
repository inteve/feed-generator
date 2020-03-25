<?php

	namespace Inteve\FeedGenerator\Feeds\Heureka;

	use Inteve\FeedGenerator\Feed;
	use Inteve\FeedGenerator\InvalidItemException;
	use Inteve\FeedGenerator\IOutput;
	use Inteve\FeedGenerator\Utils\Helpers;


	class HeurekaFeed extends Feed
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
			// https://sluzby.heureka.cz/napoveda/xml-feed/
			$output->open();
			$output->output('<?xml version="1.0" encoding="utf-8"?>');
			$output->output("\n");
			$output->output('<SHOP>');
			$output->output("\n");

			foreach ($this->items as $item) {
				if ($item === NULL) {
					continue;
				}

				if (!($item instanceof HeurekaItem)) {
					throw new InvalidItemException('Feed item must be instance of HeurekaItem.');
				}

				$item->validate();

				$output->output("<SHOPITEM>\n");

				Helpers::writeXml($output, [
					'ITEM_ID' => $item->getId(),
					'EAN' => $item->getEan(),
					'PRODUCTNAME' => $item->getProductName(),
					'MANUFACTURER' => $item->getManufacturer(),
					'DESCRIPTION' => $item->getDescription(),
					'CATEGORYTEXT' => $item->getCategoryText(),
					'URL' => $item->getUrl(),
					'IMGURL' => $item->getImageUrl(),

					// price & availability
					'PRICE_VAT' => $item->getPrice(),
					'DELIVERY_DATE' => $item->getDeliveryDate(),

					// group ID
					'ITEMGROUP_ID' => $item->getGroupId(),
				]);

				foreach ($item->getParameters() as $parameter) {
					Helpers::writeXml($output, [
						'PARAM' => [
							'content' => [
								'PARAM_NAME' => $parameter->getName(),
								'VAL' => $parameter->getValue() . $parameter->getUnit(),
							],
						],
					]);
				}

				$output->output("</SHOPITEM>\n");
			}

			$output->output('</SHOP>');
			$output->output("\n");
			$output->close();
		}
	}
