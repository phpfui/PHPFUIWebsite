<?php

namespace Example\View;

class AbideValidation
	{
	private \PHPFUI\Validator\GT $gtValidator;

	private \PHPFUI\Validator\LT $ltValidator;

	/** @param array<string, string> $parameters */
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

		$ltgtFields = new \PHPFUI\FieldSet('Date Less Than / Greater Than Example');
		$startDate = new \PHPFUI\Input\Date($this->page, 'startDate', 'Start Date', $this->parameters['startDate'] ?? '');
		$startDate->setToolTip('Must be before End Date.');

		$endDate = new \PHPFUI\Input\Date($this->page, 'endDate', 'End Date', $this->parameters['endDate'] ?? '');
		$endDate->setToolTip('Must be after Start Date.');

		$startDate->setValidator($this->ltValidator, 'Start Date must be less than End Date', $endDate->getId());
		$endDate->setValidator($this->gtValidator, 'End Date must be greater than Start Date', $startDate->getId());

		$ltgtFields->add(new \PHPFUI\MultiColumn($startDate, $endDate));
		$container->add($ltgtFields);

		$ltgtFields = new \PHPFUI\FieldSet('Time Less Than / Greater Than Example');
		$startTime = new \PHPFUI\Input\Time($this->page, 'startTime', 'Start Time', $this->parameters['startTime'] ?? '', 5);
		$startTime->setToolTip('Must be before End Time.');

		$endTime = new \PHPFUI\Input\Time($this->page, 'endTime', 'End Time', $this->parameters['endTime'] ?? '', 5);
		$endTime->setToolTip('Must be after Start Time.');

		$startTime->setValidator($this->ltValidator, 'Start Time must be less than End Time', $endTime->getId());
		$endTime->setValidator($this->gtValidator, 'End Time must be greater than Start Time', $startTime->getId());

		$ltgtFields->add(new \PHPFUI\MultiColumn($startTime, $endTime));
		$container->add($ltgtFields);

		return $container;
		}
	}
