<?php

namespace PHPFUI\ConstantContact;

class Base
	{
	public function __construct(protected \PHPFUI\ConstantContact\Client $client, protected string $urlPath)
		{
		}

	public function success() : bool
		{
		return 200 == $this->client->getLastErrorNumber();
		}

	public function getResponseCode() : int
		{
		return $this->client->getLastErrorNumber();
		}

	public function getResponseText() : string
		{
		return $this->client->getBody();
		}

	protected function doDelete(array $parameters) : string
		{
		$url = $this->getUrl($parameters);
		}

	protected function doGet(array $parameters) : string
		{
		$url = $this->getUrl($parameters);
		}

	protected function doPut(array $parameters) : string
		{
		$url = $this->getUrl($parameters);
		}

	protected function doPost(array $parameters) : string
		{
		$url = $this->getUrl($parameters);
		}

	protected function doPatch(array $parameters) : string
		{
		$url = $this->getUrl($parameters);
		}

	private function getUrl(array &$parameters) : string
		{
		$url = $this->urlPath;

		if (! \count($parameters))
			{
			return $url;
			}
		$parameter = '{' . \array_key_first($parameters) . '}';

		if (null !== \strpos($url, $parameter))
			{
			$url = \str_replace($parameter, \array_shift($parameters), $url);
			}

		return $url;
		}
	}
