<?php

namespace DeepCopy\Filter;

class KeepFilter implements Filter
{
    /**
     * Keeps the value of the object property.
     *
     * @inheritDoc
     */
    public function apply($object, $property, $objectCopier)
    {
        // Nothing to do
    }
}
