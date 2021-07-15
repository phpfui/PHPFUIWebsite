<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;

class GetLists extends GetList
{
    protected $limit;
    protected $include_count;
    protected $lists = [];

    public function __construct(Client $Client, int $limit = 50, bool $include_count = false, string $include_membership_count = "all")
    {
        parent::__construct($Client, null, $include_membership_count);

        $this->setLimit($limit);
        $this->setIncludeCount($include_count);
    }

    /**
     * @param number $limit - Min 1, Max 1000
     */
    public function setLimit(int $limit = 50) : self
    {
        if ($limit < 1) $limit = 1;
        if ($limit > 1000) $limit = 1000;

        $this->limit = $limit;

        return $this;
    }

    public function setIncludeCount(bool $on = false) : self
    {
        $this->include_count = $on;

        return $this;
    }

    /**
	 * @inheritDoc
	 *
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\GetList::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient() : void
    {
        $this->setHTTPOption(RequestOptions::QUERY, [
            'limit' => $this->limit,
            'include_count' => $this->include_count,
            'include_membership_count' => $this->include_membership_count
        ]);
    }

    /**
	 * @inheritDoc
	 *
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\GetList::handleResponse()
     */
    protected function handleResponse() : self
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 200)
        {
            $list = json_decode($body);
            if ($list->lists)
            {
                foreach ($list->lists as $i=>$ContactList)
                {
                    $list->lists[$i] = new ContactList((array) $ContactList);
                }

                $this->lists = $list->lists;
            }

            return $this;
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }

    public function lists() : array
    {
        return $this->lists;
    }

    /**
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\ContactList | null
     */
    public function getListByName(string $name)
    {
        foreach ($this->lists as $list)
        {
            if ($list->name == $name) return $list;
        }

        return null;
    }
}