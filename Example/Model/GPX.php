<?php

namespace Example\Model;

class GPX
	{

	private array $mileages = [];

	private array $rows = [];

	private float $ascent = 0.0;

	private float $descent = 0.0;

	private float $totalDistance = 0.0;

	public function __construct(private array $file, private string $unit = 'mi')
		{
		$this->name = str_replace('_', ' ', $this->file['name']);
		$dotIndex = strpos($this->name, '.');
		if ($dotIndex)
			{
			$this->name = substr($this->name, 0, $dotIndex);
			}
		}

	public function getDistance() : float
		{
		return $this->totalDistance;
		}

	public function getAscent() : int
		{
		return round($this->ascent);
		}

	public function getDescent() : int
		{
		return round($this->descent);
		}

	public function getFileName() : string
		{
		return $this->name;
		}

	public function getData() : array
		{
		return $this->rows;
		}

	public function validate() : string
		{
		$file = file_get_contents($this->file['tmp_name']);
		if (! $file)
			{
			return "Error reading file";
			}

		$xml = simplexml_load_string($file);

		if (empty($xml->trk->trkseg->trkpt))
			{
			return 'trk->trkseg->trkpt not found. Invalid GPX file.';
			}

		if (empty($xml->wpt))
			{
			return 'wpt Waypoints not found. Invalid GPX file.';
			}

		$this->totalDistance = 0.0;
		$mileage = 0.0;
		$last = null;
		$lastElevation = 0;
		$geotools = new \League\Geotools\Geotools();

		foreach ($xml->trk->trkseg->trkpt as $element)
			{
			$temp = (array)$element;
			$elevation = $temp['ele'];
			$elevationDiff = $elevation - $lastElevation;
			if ($elevationDiff > 0)
				{
				$this->ascent += $elevationDiff;
				}
			else
				{
				$this->descent += (0 - $elevationDiff);
				}
			$lastElevation = $elevation;
			$key = $temp['@attributes']['lat'] . ',' . $temp['@attributes']['lon'];
			$next = new \League\Geotools\Coordinate\Coordinate($key);
			if ($last)
				{
				$distance = $geotools->distance()->setFrom($last)->setTo($next);
				$mileage = $distance->in($this->unit)->vincenty();
				}
			$this->totalDistance += $mileage;
			$last = clone $next;
			$this->mileages[$key] = $this->totalDistance;
			}

		$this->rows = [];
		$lastMileage = 0;
		foreach ($xml->wpt as $element)
			{
			$data = (array)$element;
			$key = $data['@attributes']['lat'] . ',' . $data['@attributes']['lon'];
			$mileage = $this->mileages[$key] ?? $lastMileage;
			$gox = $mileage - $lastMileage;
			$this->rows[] = ['turn' => $data['sym'], 'street' => $data['desc'], 'distance' => $mileage, 'gox' => $gox];
			$lastMileage = $mileage;
			}

		if ($this->unit == 'mi')
			{
			$this->ascent *= 3.28084;
			$this->descent *= 3.28084;
			}

		return '';
		return new \PHPFUI\Debug($this->rows);
		}

	public function getCueSheet() : \Example\Report\Cuesheet
		{
		$cuesheet = new \Example\Report\Cuesheet();

		return $cuesheet;
		}

	}
