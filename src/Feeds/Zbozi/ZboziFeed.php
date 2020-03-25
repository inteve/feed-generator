<?php

	namespace Inteve\FeedGenerator\Feeds\Zbozi;

	use Inteve\FeedGenerator\Feed;
	use Inteve\FeedGenerator\InvalidItemException;
	use Inteve\FeedGenerator\IOutput;
	use Inteve\FeedGenerator\Utils\Helpers;


	class ZboziFeed extends Feed
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
			// https://napoveda.seznam.cz/cz/zbozi/specifikace-xml-pro-obchody/specifikace-xml-feedu/
			$output->open();
			$output->output('<?xml version="1.0" encoding="utf-8"?>');
			$output->output("\n");
			$output->output('<SHOP xmlns="http://www.zbozi.cz/ns/offer/1.0">');
			$output->output("\n");

			foreach ($this->items as $item) {
				if ($item === NULL) {
					continue;
				}

				if (!($item instanceof ZboziItem)) {
					throw new InvalidItemException('Feed item must be instance of ZboziItem.');
				}

				$item->validate();

				$output->output("<SHOPITEM>\n");

				Helpers::writeXml($output, [
					'ITEM_ID' => $item->getId(),
					'PRODUCTNAME' => $item->getProductName(),
					'DESCRIPTION' => $item->getDescription(),
					'URL' => $item->getUrl(),
					'IMGURL' => $item->getImageUrl(),
					'EAN' => $item->getEan(),

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
								'VAL' => $parameter->getValue(),
								'UNIT' => $parameter->getUnit(),
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
