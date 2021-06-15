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
				if (!($item instanceof ZboziItem)) {
					throw new InvalidItemException('Feed item must be instance of ZboziItem.');
				}

				$item->validate();

				$output->output("<SHOPITEM>\n");

				Helpers::writeXml($output, array(
					'ITEM_ID' => $item->getId(),
					'PRODUCTNAME' => $item->getProductName(),
					'DESCRIPTION' => $item->getDescription(),
					'URL' => $item->getUrl(),
					'IMGURL' => $item->getImageUrl(),
					'EAN' => $item->getEan(),

					// price & availability
					'PRICE_VAT' => $item->getPrice(),
					'DELIVERY_DATE' => $item->getDeliveryDate(),

					// custom labels
                    'CUSTOM_LABEL_0' => $item->getCustomLabel(0),
                    'CUSTOM_LABEL_1' => $item->getCustomLabel(1),
                    'CUSTOM_LABEL_3' => $item->getCustomLabel(3),

                    // group ID
					'ITEMGROUP_ID' => $item->getGroupId(),
                    'LIST_PRICE' => $item->getListPrice() ?? $item->getPrice(),
				));

				foreach ($item->getParameters() as $parameter) {
					Helpers::writeXml($output, array(
						'PARAM' => array(
							'content' => array(
								'PARAM_NAME' => $parameter->getName(),
								'VAL' => $parameter->getValue(),
								'UNIT' => $parameter->getUnit(),
							),
						),
					));
				}

				$output->output("</SHOPITEM>\n");
			}

			$output->output('</SHOP>');
			$output->output("\n");
			$output->close();
		}
	}
