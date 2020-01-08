<?php

namespace PHPFUI\Input;

/**
 * A wrapper for Select controls that is Countable
 */
class Select extends Input implements \Countable
	{
	protected $labelClass = [];

	protected $options = [];

	/**
	 * Construct a Select
	 *
	 * @param string $name of the field
	 * @param string $label optional
	 */
	public function __construct(string $name, string $label = '')
		{
		// not really text input, but just need to fake out the ctor with something valid
		parent::__construct('text', $name, $label);
		}

	public function addLabelClass(string $class) : Select
		{
		$this->labelClass[] = $class;

		return $this;
		}

	/**
	 * Add an OptGroup
	 *
	 *
	 */
	public function addOptGroup(OptGroup $group) : Select
		{
		$this->options[] = $group;

		return $this;
		}

	/**
	 * Add an option
	 *
	 * @param string $label required
	 * @param string $value optional
	 * @param bool $selected default false, pass true to preselect
	 *                     this option
	 * @param bool $disabled default false
	 *
	 */
	public function addOption(string $label, string $value = null, bool $selected = false, bool $disabled = false) : Select
		{
		$this->options[] = ['label'    => \PHPFUI\TextHelper::htmlentities($label),
												'value'    => $value,
												'selected' => $selected ? 'selected' : '',
												'disabled' => $disabled ? 'disabled' : '',];

		return $this;
		}

	/**
	 * Return the number of options added
	 *
	 */
	public function count() : int
		{
		return count($this->options);
		}

	/**
	 * remove all options.
	 *
	 */
	public function removeAll() : Select
		{
		$this->options = [];

		return $this;
		}

	/**
	 * remove an option.  Returns true on success.
	 *
	 * @param string $value of selection to be removed
	 *
	 */
	public function removeOption(string $value) : bool
		{
		foreach ($this->options as $key => $select)
			{
			if ($select['value'] == $value)
				{
				unset($this->options[$key]);

				return true;
				}
			}

		return false;
		}

	/**
	 * Select an option based on the value passed
	 *
	 * @param string $selection to be selected
	 *
	 * @return Select
	 */
	public function select($selection)
		{
		foreach ($this->options as &$values)
			{
			$values['selected'] = $values['value'] == $selection ? 'selected' : '';
			}

		return $this;
		}

	protected function getStart() : string
		{
		$label = $error = null;
		$id = $this->getId();

		if ($this->label)
			{
			$label = new \PHPFUI\HTML5Element('label');

			foreach ($this->labelClass as $class)
				{
				$label->addClass($class);
				}

			$label->addAttribute('for', $id);
			$label->add($this->getToolTip($this->label));
			}

		if ($this->required)
			{
			$this->addErrorMessage('Please select.');

			if ($label)
				{
				$label->add(' <small>Required</small>');
				}

			$this->addAttribute('required');
			}

		if ($this->errorMessages)
			{
			$error = new \PHPFUI\HTML5Element('span');
			$error->add('<br>');
			$error->add(implode('', array_keys($this->errorMessages)));
			$error->addClass('form-error');
			$this->addAttribute('aria-errormessage', $error->getId());
			}

		$class = $this->getClass();
		$attributes = $this->getAttributes();

		$this->add("<select id='{$id}'{$class}{$attributes} name='{$this->getName()}'>");

		foreach ($this->options as $option)
			{
			if (is_object($option))
				{
				$this->add($option);
				}
			else
				{
				$selected = $option['selected'];
				$disabled = $option['disabled'];
				$this->add("<option value='{$option['value']}' {$selected} {$disabled}>{$option['label']}</option>");
				}
			}

		$this->add('</select>');

		return $label . $error;
		}
	}