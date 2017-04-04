<?php

	namespace Inteve\FeedGenerator;


	class FeedGeneratorException extends \RuntimeException
	{
	}


	class FileSystemException extends FeedGeneratorException
	{
	}


	class InvalidArgumentException extends FeedGeneratorException
	{
	}


	class InvalidItemException extends FeedGeneratorException
	{
	}


	class OutputException extends FeedGeneratorException
	{
	}


	class StaticClassException extends FeedGeneratorException
	{
	}
