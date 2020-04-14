<?php

	namespace Inteve\FeedGenerator\Feeds\Glami;

	use Inteve\FeedGenerator\Feed;
	use Inteve\FeedGenerator\InvalidItemException;
	use Inteve\FeedGenerator\IOutput;
	use Inteve\FeedGenerator\ItemsGroup;
	use Inteve\FeedGenerator\Utils\Helpers;


	class GlamiFeed extends Feed
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
			// https://www.glami.cz/info/feed/
			$output->open();
			$output->output('<?xml version="1.0" encoding="utf-8"?>');
			$output->output("\n");
			$output->output('<SHOP>');
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
			if (!($item instanceof GlamiItem)) {
				throw new InvalidItemException('Feed item must be instance of GlamiItem.');
			}

			$item->validate();

			$output->output("<SHOPITEM>\n");

			Helpers::writeXml($output, [
				'ITEM_ID' => $item->getId(),
				'EAN' => $item->getEan(),
				'PRODUCTNAME' => $item->getProductName(),
				'DESCRIPTION' => $item->getDescription(),
				'CATEGORYTEXT' => $item->getCategoryText(),
				'URL' => $item->getUrl(),
				'URL_SIZE' => $item->getUrlSize(),
				'IMGURL' => $item->getImageUrl(),
			]);

			foreach ($item->getAlternativeImageUrls() as $alternativeImageUrl) {
				Helpers::writeXml($output, [
					'IMGURL_ALTERNATIVE' => $alternativeImageUrl,
				]);
			}

			Helpers::writeXml($output, [
				// price & availability
				'PRICE_VAT' => $item->getPriceVat(),
				'DELIVERY_DATE' => $item->getDeliveryDate(),

				// group ID
				'ITEMGROUP_ID' => $item->getGroupId(),

				'MANUFACTURER' => $item->getManufacturer(),
			]);

			foreach ($item->getParameters() as $parameter) {
				if (!$parameter->isFilled()) {
					continue;
				}

				Helpers::writeXml($output, [
					'PARAM' => [
						'content' => [
							'PARAM_NAME' => $parameter->getName(),
							'VAL' => $parameter->getValue(),
							'PERCENTAGE' => $parameter->getPercentage(),
						],
					],
				]);
			}

			foreach ($item->getDeliveries() as $delivery) {
				Helpers::writeXml($output, [
					'DELIVERY' => [
						'content' => [
							'DELIVERY_ID' => $delivery->getId(),
							'DELIVERY_PRICE' => $delivery->getPrice(),
							'DELIVERY_PRICE_COD' => $delivery->getPriceCod(),
						],
					],
				]);
			}

			$output->output("</SHOPITEM>\n");
		}
	}
