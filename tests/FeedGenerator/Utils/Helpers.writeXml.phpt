<?php

use Inteve\FeedGenerator\Outputs\MemoryOutput;
use Inteve\FeedGenerator\Utils\Helpers;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test(function () {
	$output = new MemoryOutput;
	Helpers::writeXml($output, array());
	Assert::same('', $output->getOutput());
});


test(function () {
	// disabling NULL tags
	$output = new MemoryOutput;
	Helpers::writeXml($output, array(
		'title' => 'Lorem ipsum',
		'content' => NULL,
		'date' => array(
			'content' => NULL,
		),
	));
	Assert::same("<title>Lorem ipsum</title>\n", $output->getOutput());
});


test(function () {
	// empty tags
	$output = new MemoryOutput;
	Helpers::writeXml($output, array(
		'title' => array(),
	));
	Assert::same("<title />\n", $output->getOutput());
});


test(function () {
	// attributes
	$output = new MemoryOutput;
	Helpers::writeXml($output, array(
		'feed' => array(
			'attrs' => array(
				'empty' => NULL,
				'xmlns' => 'http://www.w3.org/2005/Atom',
				'xmlns:g' => 'http://base.google.com/ns/1.0',
			),
		),

		'text' => array(
			'attrs' => array(
				'type' => 'html',
			),
			'content' => '<p>Lorem ipsum dolor</p>',
		),
	));
	Assert::same(implode("\n", array(
		'<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0" />',
		'<text type="html">&lt;p&gt;Lorem ipsum dolor&lt;/p&gt;</text>',
		'',
	)), $output->getOutput());
});


test(function () {
	// sub-elements
	$output = new MemoryOutput;
	Helpers::writeXml($output, array(
		'feed' => array(
			'content' => array(
				'text' => array(
					'attrs' => array(
						'type' => 'html',
					),
					'content' => 'Lorem ipsum dolor',
				),

				'images' => array(
					'content' => array(
						'image' => 'http://example.com/image.jpg',
					),
				),
			),
		),
	));
	Assert::same(implode("\n", array(
		'<feed>',
			'<text type="html">Lorem ipsum dolor</text>',
			'<images>',
				'<image>http://example.com/image.jpg</image>',
			'</images>',
		'</feed>',
		'',
	)), $output->getOutput());
});


test(function () {
	// multi-tag names
	$output = new MemoryOutput;
	Helpers::writeXml($output, array(
		'images' => array(
			'content' => array(
				array(
					'tag' => 'image',
					'content' => 'http://example.com/image1.jpg',
				),

				array(
					'tag' => 'image',
					'content' => 'http://example.com/image2.jpg',
				),
			),
		),
	));
	Assert::same(implode("\n", array(
		'<images>',
			'<image>http://example.com/image1.jpg</image>',
			'<image>http://example.com/image2.jpg</image>',
		'</images>',
		'',
	)), $output->getOutput());
});
