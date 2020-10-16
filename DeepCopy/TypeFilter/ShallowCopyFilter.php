<?php

namespace DeepCopy\TypeFilter;

/**
 * @final
 */
class ShallowCopyFilter implements TypeFilter
{
    /**
     * @inheritDoc
     */
    public function apply($element)
    {
        return clone $element;
    }
}
