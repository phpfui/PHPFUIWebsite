<?php

namespace PHPFUI\RefActor\Actor;

abstract class Base extends \PHPParser\NodeVisitorAbstract
	{

	protected \PHPFUI\RefActor $refActor;

	private string $currentFile;

	private bool $print = false;

	public function filterNode(\PhpParser\Node $node, array $nodeNames) : bool
		{
		foreach ($nodeNames as $filter)
			{
			if ($node instanceof $filter)
				{
				return true;
				}
			}

		return false;
		}

	/**
	 * Get the current file being processed
	 */
	public function getCurrentFile() : string
		{
		return $this->currentFile;
		}

	/**
	 * Return a markdown compatible description for automated documentation generation
	 *
	 * @return string of markdown
	 */
	abstract function getDescription() : string;

	public function getPrint() : bool
		{
		return $this->print;
		}

	/**
	 * Sets the $this->currentFile variable once processing has begun.  This is called after shouldProcessFile returns true.
	 */
	public function setCurrentFile(string $currentFile) : self
		{
		// normalize to linux paths, compatible with PHP on Windows
		$this->currentFile = str_replace('\\', '/', $currentFile);

		return $this;
		}

	public function setPrint(bool $print) : self
		{
		$this->print = $print;

		return $this;
		}

	/**
	 * Called by RefActor when adding an Actor.  Allows the Actor to reference the RefActor controller.
	 */
	public function setRefActor(\PHPFUI\RefActor $refActor) : self
		{
		$this->refActor = $refActor;

		return $this;
		}

	/**
	 * Called before processing a file.  Actor should reset any properties that could be left over from processing previous files.
	 *
	 * @return bool return true to process the file, or false to skip
	 */
	public function shouldProcessFile(string $file) : bool
		{
		$this->print = false;

		return true;
		}

	}
