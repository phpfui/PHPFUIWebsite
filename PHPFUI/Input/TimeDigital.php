<?php

namespace PHPFUI\Input;

/**
 * Digital Time input wrapper that ignores native pickers
 */
class TimeDigital extends Input
	{

	/**
	 * Constuct a Time input field supporting hours and minutes
	 *
	 * @param Page $page since we need to add JS
	 * @param string $name of the field
	 * @param string $label is optional
	 * @param ?string $value for initial display, can be military or
	 *                         AM/PM formated
	 * @param int $interval minute step interval, default 15.
	 */
	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', ?string $value = '', int $interval = 15)
		{
		parent::__construct('text', $name, $label, $value);
		$this->addAttribute('maxlength', 0);

		$reveal = new \PHPFUI\Reveal($page, $this);
		$reveal->addClass('tiny');

		$fieldSet = new \PHPFUI\FieldSet('Select Time');
		$div = new \PHPFUI\HTML5Element('div');

		$id = $div->getId();
		$inputId = $this->getId();
		$tp = "timePicker{$id}";
		$dollar = '$';
		$setJs = "{$dollar}('#{$inputId}').val({$tp}.format('h:mm A'))";

		$fieldSet->add($div);
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$cancel = $reveal->getCloseButton();
		$cancel->addAttribute('onClick', '$("#' . $inputId . '").val("' . $value . '")');
		$buttonGroup->addButton($cancel);
		$clear = new \PHPFUI\Button('Clear');
		$clear->addClass('warning');
		$clear->addAttribute('data-close');
		$clear->addAttribute('onClick', '$("#' . $inputId . '").val("")');
		$buttonGroup->addButton($clear);
		$set = new \PHPFUI\Button('Set');
		$set->addAttribute('onClick', $setJs);
		$set->addAttribute('data-close');
		$buttonGroup->addButton($set);
		$buttonGroup->addButtonClass('tiny');
		$buttonGroup->addClass('float-right');
		$fieldSet->add($buttonGroup);
		$reveal->add($fieldSet);
		$page->addTailScript('mtr-datepicker/mtr-datepicker.js');
		$page->addStyleSheet('mtr-datepicker/mtr-datepicker.min.css');
		$page->addStyleSheet('mtr-datepicker/mtr-datepicker.default-theme.min.css');
		$time = date('Y-m-d') . 'T' . \PHPFUI\Input\Time::toMilitary($value);
		$settings = ['target' => "'{$id}'", 'timestamp' => "(new Date('{$time}')).getTime()",
			'datepicker' => false, 'animations' => true, 'minutes' => ['min' => 0, 'max' => 59, 'step' => $interval], ];
		$js = "var {$tp} = new MtrDatepicker(" . \PHPFUI\TextHelper::arrayToJS($settings) . ");{$tp}.onChange('time',function(){{$setJs}});";
		$page->addJavaScript($js);
		}

	}
