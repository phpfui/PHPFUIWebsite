<?php

namespace PHPFUI\RefActor\Actor\Classes;

class Extract extends \PHPFUI\RefActor\Actor\Classes\Base
	{
	private bool $hasStatements = false;
	private array $legalStatements = [];
	private array $nodeFilter = [\PhpParser\Node\Stmt\Class_::class, \PhpParser\Node\Stmt\Use_::class, \PhpParser\Node\Stmt\UseUse::class,
		\PhpParser\Node\Stmt\GroupUse::class, \PhpParser\Node\Name::class, \PhpParser\Node\Stmt\Interface_::class];

	public function __construct(string $csvFileName = 'classNames.csv', string $delimiter = ',')
		{
		parent::__construct($csvFileName, $delimiter);
		}

	public function enterNode(\PhpParser\Node $node)
		{
		if ($node instanceof \PhpParser\Node\Stmt\Namespace_)
			{
			// record the current namespace for later use
			$this->setCurrentNamespace(implode('\\', $node->name->parts));

			return;
			}

		if ($this->filterNode($node, $this->nodeFilter))
			{
			// just collect use statements and such, we will add the namespace and class in later
			if (! $node instanceof \PhpParser\Node\Stmt\Class_ && ! $node instanceof \PhpParser\Node\Name && ! $node instanceof \PhpParser\Node\Stmt\Interface_)
				{
				$this->legalStatements[] = $node;
				}

			// skip entire node, we want to treat it as one unit
			return \PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
			}

		// file has statements other than legit class statements (like use and namespace), so should be targeted as needing to delete class node
		$this->hasStatements = true;


		}

	public function getDescription() : string
		{
		return 'Extracts classes found in the file being processed and write them out to a new file';
		}

	public function getTestCases() : array
		{
		$testCases = [];

		///////// Test Case 1 ///////////////////
		$original = <<<'PHP'
<?php
class SomeClass
	{
	public function someMethod() : string
		{
		return 'something';
		}
	}
$someCode = getcwd();
PHP;

		$modified = <<<'PHP'
<?php

$someCode = getcwd();
PHP;

		$extra = <<<PHP
<?php

namespace NewNamespace;

class SomeClass
{
    public function someMethod() : string
    {
        return 'something';
    }
}
PHP;

		$testCases[] = [$original, $modified, $extra];

		return $testCases;
		}

	public function leaveNode(\PhpParser\Node $node)
		{
		// only interested in classes at this point
		if (! ($node instanceof \PhpParser\Node\Stmt\Class_))
			{
			return;
			}

		// now we have a class and we know if there are non class statements in the file
		// first see if we should rename the class
		$fqn = $this->getCurrentNamespace() . '\\' . $node->name->name;

		$row = $this->getClassInfo($fqn);

		if (empty($row))
			{
			// unknown class, skip it
			$this->refActor->log('notice', 'Unknown class ' . $fqn);

			return;
			}

		// we need to rename and print it to new file path
		$newNamespace = $this->getCorrectNamespace($row);
		$newClassName = $this->getCorrectClassName($row);
		$newFile = $this->getCorrectFileName($row);

		if ($newNamespace == $this->getCurrentNamespace() && $newClassName == $node->name->name && $newFile == $this->getCurrentFile() && ! $this->hasStatements)
			{
			// nothing to do, everything is the same
			return;
			}

		// we need to update the file
		$statements = $this->legalStatements;
		// add in class to end of legal statements
		$statements[] = $node;
		// prepend correct namespace
		$namespaceNode = new \PhpParser\Node\Stmt\Namespace_(new \PhpParser\Node\Name($newNamespace));

		$namespaceNode->stmts = $statements;
		$this->refActor->printToFile($this->getBaseDirectory() . '/' . $newFile, [$namespaceNode]);

		// same class and file info, but has extra statements
		if ($newNamespace == $this->getCurrentNamespace() && $newClassName == $node->name->name && $newFile == $this->getCurrentFile())
			{
			// we are not going to automatically change the file, as we already overwrote it above, without the extra statements
			return;
			}

		// remove the class from the file, since it moved and should has been renamed and should not be mixed with other statements
		$this->setPrint(true);

		return \PhpParser\NodeTraverser::REMOVE_NODE;
		}

	public function shouldProcessFile(string $file) : bool
		{
		$this->hasStatements = false;
		$this->legalStatements = [];

		return parent::shouldProcessFile($file);
		}

	}
