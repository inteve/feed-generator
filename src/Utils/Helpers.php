<?php

	namespace Inteve\FeedGenerator\Utils;

	use Inteve\FeedGenerator\AssertException;
	use Inteve\FeedGenerator\IOutput;


	class Helpers
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		/**
		 * @param  string
		 * @return string
		 */
		public static function escapeXml($s)
		{
			return htmlspecialchars(preg_replace('#[\x00-\x08\x0B\x0C\x0E-\x1F]+#', '', $s), ENT_QUOTES);
		}


		/**
		 * Escapes URL parameter.
		 * @param  string
		 * @return string
		 */
		public static function escapeUrl($s)
		{
			return rawurlencode($s);
		}


		/**
		 * Formats XML tag
		 * @param  string
		 * @param  string|NULL
		 * @param  array
		 * @return string
		 */
		public static function writeXml(IOutput $output, array $xml)
		{
			foreach ($xml as $tagName => $content) {
				if ($content === NULL || (is_array($content) && array_key_exists('content', $content) && $content['content'] === NULL)) {
					continue;
				}

				$tag = $tagName;

				if (is_array($content) && isset($content['tag'])) {
					$tag = $content['tag'];
				}

				// open tag
				$output->output('<' . $tag);

				if (is_array($content) && isset($content['attrs'])) {
					foreach ($content['attrs'] as $attrName => $attrValue) {
						if ($attrValue === NULL) {
							continue;
						}

						$output->output(' ' . $attrName . '="' . self::escapeXml($attrValue) . '"');
					}
				}

				$isEmpty = is_array($content) && !isset($content['content']);

				if ($isEmpty) {
					$output->output(' /');
				}

				$output->output('>');

				if (!$isEmpty) {
					// content
					if (is_array($content) && isset($content['content'])) {
						if (is_array($content['content'])) {
							$output->output("\n");
							self::writeXml($output, $content['content']);

						} else {
							$output->output(self::escapeXml($content['content']));
						}

					} else {
						$output->output(self::escapeXml($content));
					}

					// close tag
					$output->output('</' . $tag . ">");
				}

				$output->output("\n");
			}
		}
	}
