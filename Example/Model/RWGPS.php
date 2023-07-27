<?php

namespace Example\Model;

class RWGPS
	{
	private float $ascent = 0.0;

	private float $descent = 0.0;

	private string $name = '';

	/** @var array<string, string | float> */
	private array $rows = [];

	private float $totalDistance = 0.0;

	public function __construct(private string $url, private string $unit = 'Miles')
		{
		}

	public function getAscent() : float
		{
		return \round($this->getSmallUnits($this->ascent));
		}

	/** @return array<string, string | float> */
	public function getData() : array
		{
		return $this->rows;
		}

	public function getDescent() : float
		{
		return \round($this->getSmallUnits($this->descent));
		}

	public function getDistance() : float
		{
		return $this->getBigUnits($this->totalDistance);
		}

	public function getTitle() : string
		{
		return $this->name;
		}

	public function validate() : string
		{
		$parts = \parse_url($this->url);
		$parts['path'] .= '.json';
		$json = \file_get_contents($this->unparse_url($parts));

		if (empty($json))
			{
			return $this->url . ' does not appear to be a valid Ride With GPS link.';
			}

		$data = \json_decode($json, true);

		if (empty($data['has_course_points']))
			{
			return $this->url . ' does not have street directions.';
			}

		$this->name = $data['name'];
		$this->ascent = $data['elevation_gain'];
		$this->descent = $data['elevation_loss'];
		$this->totalDistance = (float)$data['distance'];

		$distance = 0.0;
		$this->rows = [];
		$lastDistance = 0;

// d	1811.871
// n	"Turn right onto School St"
// t	"Right"

		foreach ($data['course_points'] as $point)
			{
			$distance = (float)$point['d'];
			$gox = $distance - $lastDistance;
			$this->rows[] = ['turn' => $point['t'], 'street' => $point['n'], 'distance' => $this->getBigUnits($distance), 'gox' => $this->getBigUnits($gox)];
			$lastDistance = $distance;
			}

		return '';
		}

	private function getBigUnits(float $meters) : float
		{
		if ('Miles' == $this->unit)
			{
			// return miles
			return $meters * 0.000621371;
			}

		// must want kilometers
		return $meters / 1000;
		}

	private function getSmallUnits(float $meters) : float
		{
		if ('Miles' == $this->unit)
			{
			// return feet
			return $meters * 3.28084;
			}

		// must want meters
		return $meters;
		}

	/**
	 * @param array<string, string> $parsed_url
	 */
	private function unparse_url(array $parsed_url) : string
		{
		$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host = $parsed_url['host'] ?? '';
		$port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user = $parsed_url['user'] ?? '';
		$pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
		$pass = ($user || $pass) ? "{$pass}@" : '';
		$path = $parsed_url['path'] ?? '';
		$query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

		return "{$scheme}{$user}{$pass}{$host}{$port}{$path}{$query}{$fragment}";
		}

	}
