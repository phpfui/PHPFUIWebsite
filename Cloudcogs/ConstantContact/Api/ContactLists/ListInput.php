<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\AbstractSchema;

class ListInput extends AbstractSchema
{
    /**
     * The name given to the contact list
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * The name given to the contact list
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Text describing the list.
     */
    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Text describing the list.
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Identifies whether or not the account has favorited the contact list.
     */
    public function setFavorite(bool $favorite) :  self
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Identifies whether or not the account has favorited the contact list.
     */
    public function isFavorite() : bool
    {
        return (bool) $this->favorite;
    }
}