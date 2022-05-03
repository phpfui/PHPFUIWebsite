<?php

namespace Example\View;

class AbideValidation
	{

	private \PHPFUI\Validator\GT $gtValidator;

	private \PHPFUI\Validator\LT $ltValidator;

	public function __construct(private \PHPFUI\Page $page, private array $parameters)
		{
		$this->gtValidator = new \PHPFUI\Validator\GT();
		$this->ltValidator = new \PHPFUI\Validator\LT();

		$this->page->addAbideValidator($this->gtValidator);
		$this->page->addAbideValidator($this->ltValidator);
		}

	public function render() : \PHPFUI\Container
		{
		$container = new \PHPFUI\Container();

		$ltgtFields = new \PHPFUI\FieldSet('Less Than / Greater Than Example');
		$startDate = new \PHPFUI\Input\Date($this->page, 'startDate', 'Start Date', $this->parameters['startDate'] ?? '');
		$startDate->setToolTip('Must be before End Date.');

		$endDate = new \PHPFUI\Input\Date($this->page, 'endDate', 'End Date', $this->parameters['endDate'] ?? '');
		$endDate->setToolTip('Must be after Start Date.');

		$startDate->setValidator($this->ltValidator, 'Start Date must be less than End Date', $endDate->getId());
		$endDate->setValidator($this->gtValidator, 'End Date must be greater than Start Date', $startDate->getId());

		$ltgtFields->add(new \PHPFUI\MultiColumn($startDate, $endDate));
		$container->add($ltgtFields);

		return $container;
		}

	}
