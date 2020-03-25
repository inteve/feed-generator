<?php

use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Inteve\FeedGenerator\Utils\Helpers;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	Helpers::writeXml($output, []);
	Assert::same('', $output->getOutput());
});


test(function () {
	// disabling NULL tags
	$output = new MemoryOutput;
	Helpers::writeXml($output, [
		'title' => 'Lorem ipsum',
		'content' => NULL,
		'date' => [
			'content' => NULL,
		],
	]);
	Assert::same("<title>Lorem ipsum</title>\n", $output->getOutput());
});


test(function () {
	// empty tags
	$output = new MemoryOutput;
	Helpers::writeXml($output, [
		'title' => [],
	]);
	Assert::same("<title />\n", $output->getOutput());
});


test(function () {
	// attributes
	$output = new MemoryOutput;
	Helpers::writeXml($output, [
		'feed' => [
			'attrs' => [
				'empty' => NULL,
				'xmlns' => 'http://www.w3.org/2005/Atom',
				'xmlns:g' => 'http://base.google.com/ns/1.0',
			],
		],

		'text' => [
			'attrs' => [
				'type' => 'html',
			],
			'content' => '<p>Lorem ipsum dolor</p>',
		],
	]);
	Assert::same(implode("\n", [
		'<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0" />',
		'<text type="html">&lt;p&gt;Lorem ipsum dolor&lt;/p&gt;</text>',
		'',
	]), $output->getOutput());
});


test(function () {
	// sub-elements
	$output = new MemoryOutput;
	Helpers::writeXml($output, [
		'feed' => [
			'content' => [
				'text' => [
					'attrs' => [
						'type' => 'html',
					],
					'content' => 'Lorem ipsum dolor',
				],

				'images' => [
					'content' => [
						'image' => 'http://example.com/image.jpg',
					],
				],
			],
		],
	]);
	Assert::same(implode("\n", [
		'<feed>',
			'<text type="html">Lorem ipsum dolor</text>',
			'<images>',
				'<image>http://example.com/image.jpg</image>',
			'</images>',
		'</feed>',
		'',
	]), $output->getOutput());
});


test(function () {
	// multi-tag names
	$output = new MemoryOutput;
	Helpers::writeXml($output, [
		'images' => [
			'content' => [
				[
					'tag' => 'image',
					'content' => 'http://example.com/image1.jpg',
				],

				[
					'tag' => 'image',
					'content' => 'http://example.com/image2.jpg',
				],
			],
		],
	]);
	Assert::same(implode("\n", [
		'<images>',
			'<image>http://example.com/image1.jpg</image>',
			'<image>http://example.com/image2.jpg</image>',
		'</images>',
		'',
	]), $output->getOutput());
});
