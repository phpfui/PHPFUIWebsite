<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\AbstractAPI;
use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\ContactLists\Exception\InvalidList;

class PutList extends AbstractAPI
{
    private const SERVICE_URI = "/contact_lists";

    protected $list_id;
    protected $ListInput;

    public function __construct(Client $Client, string $list_id = null)
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);

        $this->list_id = $list_id;
        $this->ListInput = new ListInput();
    }

    /**
	 * @inheritDoc
	 *
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient() : void
    {
        $this->serviceURL = $this->serviceURL."/".$this->list_id;
        $this->setHTTPOption(RequestOptions::BODY, (string) $this->ListInput);
    }

    /**
     * @inheritDoc
	 *
	 * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::handleResponse()
     */
    protected function handleResponse()
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 200)
        {
            $list = json_decode($body);
            if ($list->list_id)
            {
                return new ContactList((array) $list);
            }

            throw new InvalidList($this->list_id);
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }

    /**
	 * @inheritDoc
	 *
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::send()
     */
    public function send()
    {
        return $this->put();
    }

    /**
     * The name given to the contact list
     */
    public function setName(string $name) : self
    {
        $this->ListInput->setName($name);

        return $this;
    }

    /**
	 * Text describing the list.
     */
    public function setDescription(string $description) : self
    {
        $this->ListInput->setDescription($description);

        return $this;
    }

    /**
     * Identifies whether or not the account has favorited the contact list.
     */
    public function setFavorite(bool $favorite) : self
    {
        $this->ListInput->setFavorite($favorite);

        return $this;
    }

    /**
	 * Overload `PutList` to call operations on wrapped `ListInput` object
	 *
     * @throws \Exception
     */
    public function __call(string $method, array $arguments) : self
    {
        if ($this->ListInput instanceof \Cloudcogs\ConstantContact\Api\ContactLists\ListInput)
        {
            call_user_func_array([$this->ListInput, $method], $arguments);

            return $this;
        }

        throw new \Exception('Requested Method does not exist!');
    }
}