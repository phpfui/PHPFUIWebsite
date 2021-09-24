<?php

namespace PHPFUI;

/**
 * InputGroup allows you to add buttons and labels to input classes.
 */
class InputGroup extends \PHPFUI\HTML5Element
	{

	private $inputLabel = null;

	private $error = '';

	private $hint = '';

	public function __construct()
		{
		parent::__construct('span');
		$this->addClass('input-group');
		}

	public function addButton(Button $button) : InputGroup
		{
		$span = new HTML5Element('span');
		$span->addClass('input-group-button');
		if ($button->getElement() == 'button')
			{
			$button->setElement('span');
			$button->deleteAttribute('type');
			}
		$span->add($button);
		$this->add($span);

		return $this;
		}

	/**
	 * Due to necessary modifications to the Input class (redoing the label), the passed Input class should be fully formed before being added to the InputGroup
	 */
	public function addInput(Input $input) : InputGroup
		{
		if (method_exists($input, 'getError'))
			{
			$this->error = $input->getError();
			}
		if (method_exists($input, 'getHint'))
			{
			$this->hint = $input->getHint();
			$input->setHint('');
			}
		$input->addClass('input-group-field');
		if (method_exists($input, 'getLabel'))
			{
			$this->inputLabel = $input->getLabel();
			if ($this->inputLabel)
				{
				$this->inputLabel = $input->getToolTip($this->inputLabel);
				if ($input->getRequired())
					{
					$this->inputLabel .= \PHPFUI\Language::$required;
					}
				}
			$input->setLabel('');
			}
		$this->add($input);

		return $this;
		}

	public function addLabel(string $label) : InputGroup
		{
		$span = new HTML5Element('span');
		$span->addClass('input-group-label');
		$span->add($label);
		$this->add($span);

		return $this;
		}

	public function getStart() : string
		{
		$retVal = '';
		$this->walk('setHint', '');
		if ($this->inputLabel)
			{
			$retVal .= '<label>' . $this->inputLabel;
			}
		return $retVal . parent::getStart();
		}

	public function getEnd() : string
		{
		$retVal = parent::getEnd() . $this->error;

		if ($this->inputLabel)
			{
			$retVal .= '</label>';
			}
		$retVal .= $this->hint;

		return $retVal;
		}

	}
