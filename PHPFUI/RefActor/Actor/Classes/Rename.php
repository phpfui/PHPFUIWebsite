<?php

namespace PHPFUI\RefActor\Actor\Classes;

class Rename extends \PHPFUI\RefActor\Actor\Classes\Base
	{

	private array $filterNodes = [\PhpParser\Node\Expr\New_::class, \PhpParser\Node\Expr\ClassConstFetch::class, \PhpParser\Node\Expr\StaticCall::class];


	public function __construct(string $csvFileName = 'classNames.csv', string $delimiter = ',')
		{
		parent::__construct($csvFileName, $delimiter);
		}

  public function enterNode(\PhpParser\Node $node) : void
		{
		if ($node instanceof \PhpParser\Node\Stmt\Namespace_)
			{
			// record the current namespace for later use
			$this->setCurrentNamespace(implode('\\', $node->name->parts));
			}
		}

	public function getDescription() : string
		{
		return 'Changes class references to new class name as defined in csv file';
		}

	public function leaveNode(\PhpParser\Node $node)
		{
		// only interested in new at this point
		if (! $this->filterNode($node, $this->filterNodes))
			{
			return null;
			}

		if ($node->class instanceof \PhpParser\Node\Name)
			{
			$fqn = $this->getCurrentNamespace() . '\\' . implode('\\', $node->class->parts);
			}
		else
			{
			$fqn = implode('\\', $node->class->parts);
			}

		$row = $this->getClassInfo($fqn);

		if (empty($row))
			{
			// unknown class, skip it
			return;
			}

		$node->class = new \PhpParser\Node\Name\FullyQualified($this->getCorrectNamespace($row) . '\\' . $this->getCorrectClassName($row));

		$this->setPrint(true);

		return $node;
		}

	}
