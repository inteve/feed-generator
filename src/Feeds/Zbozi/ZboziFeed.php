<?php

	namespace Inteve\FeedGenerator\Feeds\Zbozi;

	use Inteve\FeedGenerator\Feed;
	use Inteve\FeedGenerator\InvalidItemException;
	use Inteve\FeedGenerator\IOutput;
	use Inteve\FeedGenerator\ItemsGroup;
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
			// https://napoveda.zbozi.cz/xml-feed/specifikace/
			$output->open();
			$output->output('<?xml version="1.0" encoding="utf-8"?>');
			$output->output("\n");
			$output->output('<SHOP xmlns="http://www.zbozi.cz/ns/offer/1.0">');
			$output->output("\n");

			foreach ($this->items as $item) {
				if ($item === NULL) {
					continue;
				}

				if ($item instanceof ItemsGroup) {
					foreach ($item->getItems() as $groupItem) {
						$this->generateItem($groupItem, $output);
					}

				} else {
					$this->generateItem($item, $output);
				}
			}

			$output->output('</SHOP>');
			$output->output("\n");
			$output->close();
		}


		/**
		 * @return void
		 */
		private function generateItem($item, IOutput $output)
		{
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
				'CATEGORYTEXT' => $item->getCategoryText(),

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
	}
