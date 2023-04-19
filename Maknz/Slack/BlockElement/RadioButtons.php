<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\Object\Option;

class RadioButtons extends Options
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'radio_buttons';

    /**
     * Whether one of the radio buttons is initially selected.
     *
     * @var bool
     */
    protected $hasInitialOption = false;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'action_id' => 'action_id',
        'options'   => 'options',
        'confirm'   => 'confirm',
    ];

    /**
     * Get the intially selected option.
     *
     * @return \Maknz\Slack\Object\Option|null
     */
    public function getInitialOption()
    {
        foreach ($this->getOptions() as $option) {
            if ($option->isInitiallySelected()) {
                return $option;
            }
        }

        return null;
    }

    /**
     * Add an option to the radio buttons.
     *
     * @param mixed $option
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function addOption($option)
    {
        if ((is_array($option) && ! empty($option['selected']))
            || ($option instanceof Option && ! $option->isInitiallySelected())
        ) {
            if ($this->hasInitialOption) {
                throw new InvalidArgumentException('Only one option can be initially selected');
            }

            $this->hasInitialOption = true;
        }

        return parent::addOption($option);
    }

    /**
     * Clear options available.
     *
     * @return $this
     */
    public function clearOptions()
    {
        $this->hasInitialOption = false;

        return parent::clearOptions();
    }

    /**
     * Convert the block to its array representation.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'type'      => $this->getType(),
            'action_id' => $this->getActionId(),
            'options'   => $this->getOptionsAsArrays(),
        ];

        if ($this->hasInitialOption) {
            $initialOption = $this->getInitialOption();
            if ($initialOption !== null) {
                $data['initial_option'] = $initialOption->toArray();
            }
        }

        $confirm = $this->getConfirm();
        if ($confirm !== null) {
            $data['confirm'] = $confirm->toArray();
        }

        return $data;
    }
}
