<?php

namespace PHPFUI\InstaDoc;

class ChildClasses
	{
	/**
	 * @var array indexed by fqn of class containing array of fqn of children
	  */
	private $children = [];
	private $directory;

	public function __construct(string $directory)
		{
		$this->directory = $directory;
		}

	public function generate() : self
		{
		$classes = NamespaceTree::getAllClasses();

		foreach ($classes as $class)
			{
			try
				{
				$reflection = new \ReflectionClass($class);
				$parent = $reflection->getParentClass();
				if ($parent)
					{
					$parentName = $parent->getName();
					if (isset($this->children[$parentName]))
						{
						$this->children[$parentName][] = $reflection->getName();
						}
					else
						{
						$this->children[$parentName] = [$reflection->getName()];
						}
					}
				}
			catch (\throwable $e)
				{
				}
			}

		return $this;
		}

	public function load(string $file = '') : bool
		{
		if (empty($file))
			{
			$file = 'ChildClasses.serial';
			}
		$file = $this->directory . $file;
		if (! file_exists($file))
			{
			$this->generate();

			return true;
			}

		$contents = file_get_contents($file);
		$temp = unserialize($contents);

		if (! $temp)
			{
			return false;
			}

		$this->children = $temp;

		return true;
		}

	public function save(string $file = '') : bool
		{
		if (empty($file))
			{
			$file = 'ChildClasses.serial';
			}
		$file = $this->directory . $file;

		foreach ($this->children as &$childClasses)
			{
			sort($childClasses);
			}

		return file_put_contents($file, serialize($this->children)) > 0;
		}

	public function getChildClasses(string $fqn) : array
		{
		return $this->children[$fqn] ?? [];
		}

	}
