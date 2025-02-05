<?php

	namespace Inteve\FeedGenerator\Feeds\Zbozi;

	use Nette\Utils\Strings;


	class ZboziItemExtraMessage
	{
		const FreeGift = 'free_gift';
		const ExtendedWarranty = 'extended_warranty';
		const Voucher = 'voucher';
		const FreeAccessories = 'free_accessories';
		const FreeCase = 'free_case';
		const FreeInstallation = 'free_installation';
		const ExtendedReturn = 'extended_return';
		const FreeReturn = 'free_return';
		const PremiumInstallation = 'premium_installation';
		const AppliancePickup = 'appliance_pickup';
		const AuthorizedService = 'authorized_service';
		const SplitPayment = 'split_payment';
		const PayLater = 'pay_later';
		const GiftPackage = 'gift_package';
		const Custom = 'custom';

		/** @var string */
		private $type;

		/** @var string|NULL */
		private $text;


		/**
		 * @param  string $type
		 * @param  string|NULL $text
		 */
		public function __construct($type, $text = NULL)
		{
			$this->type = $type;
			$this->text = $text;
		}


		/**
		 * @return string
		 */
		public function getType()
		{
			return $this->type;
		}


		/**
		 * @return string|NULL
		 */
		public function getText()
		{
			return $this->text;
		}


		/**
		 * @return string|NULL
		 */
		public function getTextTag()
		{
			return Strings::upper($this->type) . '_TEXT';
		}
	}
