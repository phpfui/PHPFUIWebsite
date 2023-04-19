<?php
namespace Maknz\Slack\Block;

use InvalidArgumentException;
use Maknz\Slack\Block;
use Maknz\Slack\BlockElement;
use Maknz\Slack\BlockElement\Text;
use Maknz\Slack\FieldsTrait;
use UnexpectedValueException;

class Section extends Block
{
    use FieldsTrait;

    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'section';

    /**
     * The text for the section.
     *
     * @var \Maknz\Slack\BlockElement\Text
     */
    protected $text;

    /**
     * Fields to appear in the section.
     *
     * @var \Maknz\Slack\BlockElement\Text[]
     */
    protected $fields = [];

    /**
     * Block element to be included in the section.
     *
     * @var \Maknz\Slack\BlockElement
     */
    protected $accessory;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'text'      => 'text',
        'block_id'  => 'block_id',
        'fields'    => 'fields',
        'accessory' => 'accessory',
    ];

    /**
     * Get the class name of valid fields.
     *
     * @return string
     */
    protected function getFieldClass()
    {
        return Text::class;
    }

    /**
     * Get the section text.
     *
     * @return \Maknz\Slack\BlockElement\Text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the section text.
     *
     * @param mixed $text
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setText($text)
    {
        $this->text = Text::create($text);

        return $this;
    }

    /**
     * Add a field to the block.
     *
     * @param mixed $field
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function addField($field)
    {
        $field = $this->getFieldClass()::create($field);

        $this->fields[] = $field;

        return $this;
    }

    /**
     * Get the section accessory.
     *
     * @return \Maknz\Slack\BlockElement
     */
    public function getAccessory()
    {
        return $this->accessory;
    }

    /**
     * Set the section accessory.
     *
     * @param mixed $accessory
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setAccessory($accessory)
    {
        $accessory = BlockElement::factory($accessory);

        if ( ! $accessory->isValidFor($this)) {
            throw new InvalidArgumentException('Block element '.get_class($accessory).' is not valid for '.static::class);
        }

        $this->accessory = $accessory;

        return $this;
    }

    /**
     * Convert the block to its array representation.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'type' => $this->getType(),
        ];

        if ($this->getText()) {
            $data['text'] = $this->getText()->toArray();
        }

        if (count($this->getFields())) {
            $data['fields'] = $this->getFieldsAsArrays();
        } elseif ( ! $this->getText()) {
            throw new UnexpectedValueException('Section requires text attribute if no fields attribute is provided');
        }

        if ($this->getBlockId()) {
            $data['block_id'] = $this->getBlockId();
        }

        if ($this->getAccessory()) {
            $data['accessory'] = $this->getAccessory()->toArray();
        }

        return $data;
    }
}
