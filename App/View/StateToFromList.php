<?php

namespace Example\View;

class StateToFromList extends \PHPFUI\ToFromList
	{
	public function __construct(\PHPFUI\Page $page, string $name, private \Example\Model\State $model, array $inGroup, array $notInGroup)
		{
		$this->model = $model;
		$callback = [$this, 'callback', ];
		parent::__construct($page, $name, $inGroup, $notInGroup, 'index', $callback);
		$this->setInName('Starts with Vowel');
		$this->setOutName('Starts with Consonant');
		}

	protected function callback(string $fieldName, string $index, int $userData, string $type) : string
		{
		$state = $this->model->getState($userData);

		return $state['name'] . new \PHPFUI\Input\Hidden("{$fieldName}-{$type}[]", (string)$userData);
		}
	}
