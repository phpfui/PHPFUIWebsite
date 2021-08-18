<?php

namespace PHPFUI\ConstantContact\Definition;

class WebhooksSubscription extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var int $topic_id Identifies the topic using an integer to indicate the type of topic.
	 * @var string $hook_uri Your webhook callback URI. Constant Contact automatically sends POST requests to this URI to notify you about the topic.
	 * @var string $topic_name The name of the topic.
	 * @var string $topic_description A description of what the topic is and when Constant Contact notifies you concerning it.
	 */

	protected static array $fields = [
		'topic_id' => 'int',
		'hook_uri' => 'string',
		'topic_name' => 'string',
		'topic_description' => 'string',

	];
	}