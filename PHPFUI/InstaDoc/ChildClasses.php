<?php

namespace PHPFUI\InstaDoc;

class ChildClasses
	{
	/**
	 * @var array indexed by fqn of class containing array of fqn of children
	  */
	private $children = [];
	private $fileName = '';

	public function __construct(string $fileName = 'childClasses.serial')
		{
		$this->fileName = $fileName;
		}

	public function generate(NamespaceTree $namespaceTree) : self
		{
		$classes = NamespaceTree::getAllClasses($namespaceTree);

		foreach ($classes as $class)
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

		return $this;
		}

	public function load(string $file = '') : bool
		{
		if (empty($file))
			{
			$file = $this->fileName;
			}
		if (!file_exists($file))
			{
			return false;
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
			$file = $this->fileName;
			}

		foreach ($this->children as &$childClasses)
			{
			sort($childClasses);
			}

		return file_put_contents($file, serialize($this->children)) > 0;
		}

	public function getChildClasses(string $fqn) : array
		{
		if (! empty($this->children[$fqn]))
			{
			return $this->children[$fqn];
			}

		return [];
		}

	}
