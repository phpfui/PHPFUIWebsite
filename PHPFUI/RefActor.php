<?php

namespace PHPFUI;

class RefActor implements \PhpParser\ErrorHandler
	{

	private array $actors = [];

	private string $currentFile;

	private array $directories = [];

	private array $files = [];

	private \PhpParser\Lexer\Emulative $lexer;

	private ?\Psr\Log\LoggerInterface $logger;

	private \PhpParser\Parser $parser;

	private int $PHPVersion;

	private \PhpParser\PrettyPrinter\Standard $printer;

	private array $reviews = [];

	private bool $testing;

	private array $tests = [];

	public function __construct()
		{
		// initialize all the parameters to defaults
		$reflection = new \ReflectionClass($this);
		$methods = $reflection->getMethods();

		foreach ($methods as $method)
			{
			$name = $method->name;

			if (0 === strpos($name, 'set'))
				{
				// call the set function with default parameters
				$this->{$name}();
				}
			}
		$factory = new \PhpParser\ParserFactory();
		$this->lexer = new \PhpParser\Lexer\Emulative([
				'usedAttributes' => [
						'comments',
						'startLine', 'endLine',
						'startTokenPos', 'endTokenPos',
				],
		]);
		$this->parser = $factory->create($this->PHPVersion, $this->lexer);
		$this->printer = new \PhpParser\PrettyPrinter\Standard();
		}

	/**
	 * Actors are processed in order of addition for each file processed.
	 */
	public function addActor(\PHPFUI\RefActor\Actor\Base $actor) : self
		{
		$actor->setRefActor($this);
		$this->actors[get_class($actor)] = $actor;

		return $this;
		}

	/**
	 * Directories are processed in order of adding, then files by OS order defined by DirectoryIterator
	 */
	public function addDirectory(string $directory, bool $recurseIntoDirectories = true, array $fileExtensions = ['.php']) : self
		{
		$this->directories[$directory] = ['recurse' => $recurseIntoDirectories, 'ext' => $fileExtensions];

		return $this;
		}

	/**
	 * Files are processed after directories in order added. You can add a file from an Actor if
	 * desired.
	 */
	public function addFile(string $file) : self
		{
		$this->files[$file] = time();

		return $this;
		}

	public function clearReviews() : self
		{
		$this->reviews = [];

		return $this;
		}

	/**
	 * Return the current PHP version being parsed
	 */
	public function getPHPVersion() : int
		{
		return $this->PHPVersion;
		}

	/**
	 * Reviews are critiques of Actors, generally errors, warnings, etc.
	 *
	 * @param string[] $types array of types to return (method names from \Psr\Log\LoggerInterface) or empty for all
	 *
	 * @return [$type][]
	 */
	public function getReviews(array $types = []) : array
		{
		if (empty($types))
			{
			return $this->reviews;
			}

		$retVals = [];

		foreach ($types as $type)
			{
			$retVals[$type] = $this->reviews[$type] ?? [];
			}

		return $retVals;
		}

	/**
	 * Return results if testing is turned on. Array keys are file names.
	 */
	public function getTests() : array
		{
		return $this->tests;
		}

	/**
	 * PHPParser error handler
	 */
	public function handleError(\PhpParser\Error $error) : void
		{
		$line = -1 != $error->getStartLine() ? 'Line: ' . $error->getStartLine() : '';
		$this->log('error', "PhpParser error: {$error->getRawMessage()} in file {$this->currentFile} {$line}");
		}

	public function log(string $type, string $message, array $context = []) : self
		{
		$this->reviews[$type][] = $message;

		if ($this->logger)
			{
			$this->logger->{$type}($message, $context);
			}

		return $this;
		}

	/**
	 * Start Actors peforming refactoring with the current settings
	 */
	public function perform() : self
		{
		$this->clearReviews();

		foreach ($this->directories as $directory => $settings)
			{
			$extensions = array_flip($settings['ext']);

			try
				{
				if ($settings['recurse'])
					{
					$iterator = new \RecursiveIteratorIterator(
							new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
							\RecursiveIteratorIterator::SELF_FIRST);
					}
				else
					{
					$iterator = new \DirectoryIterator($directory);
					}
				}
			catch (\Throwable $e)
				{
				$this->log('error', __METHOD__ . ': ' . $e->getMessage());

				continue;
				}

			foreach ($iterator as $item)
				{
				if ('file' == $item->getType())
					{
					$file = $item->getPathname();
					$ext = strrchr($file, '.');

					if ($ext && isset($extensions[$ext]))
						{
						$this->processFile($file);
						}
					}
				}
			}

		foreach ($this->files as $file => $timeAdded)
			{
			$this->processFile($file);
			}

		return $this;
		}

	/**
	 * Output statements to a file.  Will include the beginning opening php tag.
	 */
	public function printToFile(string $newFile, array $statements) : self
		{
		$this->log('notice', 'Printing new file ' . $newFile);
		$newCode = $this->printer->prettyPrintFile($statements);
		$parts = explode('/', $newFile);
		array_pop($parts);
		$path = implode('/', $parts);

		if (! file_exists($path))
			{
			mkdir($path, 0777, true);
			}
		$this->output($newFile, $newCode);

		return $this;
		}

	/**
	 * You can process one file at a time if you like
	 */
	public function processFile(string $file) : self
		{
	  if (! file_exists($file))
		  {
			$this->log('error', "File {$file} not found");

			return $this;
		  }

		$this->currentFile = $file;
		$this->log('info', 'Start processing ' . $file);

		$PHP = file_get_contents($file);
		$newPHP = $this->processPHP($PHP, $file);

		if (null === $newPHP)
			{
			$this->log('error', 'Error processing ' . $file);
			}
		else
			{
			$this->log('info', 'Done processing ' . $file);
			}

		if (strlen($newPHP))
			{
			$this->output($file, $newPHP);
			}

		return $this;
		}

	/**
	 * Process a string as PHP code
	 *
	 * @return ?string null is an error, an empty string is no change, else changed PHP code
	 */
	public function processPHP(string $PHP, string $file = '') : ?string
		{
		$newPhp = null;

		try
			{
			$traverser = new \PhpParser\NodeTraverser();
			$traverser->addVisitor(new \PhpParser\NodeVisitor\CloningVisitor());

			$actorCount = 0;

			foreach ($this->actors as $actor)
				{
				if ($actor->shouldProcessFile($file))
					{
					$actor->setCurrentFile($file);
					$traverser->addVisitor($actor);
					++$actorCount;
					}
				}

			// did any actor want to process a file?
			if (! $actorCount)
				{
				return '';
				}

			$oldStmts = $this->parser->parse($PHP, $this);

			if (! is_array($oldStmts))
				{
				$this->log('error', 'Error parsing file ' . $file);

				return $newPhp;
				}

			$oldTokens = $this->lexer->getTokens();
			$newStmts = $traverser->traverse($oldStmts);

			$applied = [];

			foreach ($this->actors as $actor)
				{
				if ($actor->getPrint())
					{
					$applied[] = get_class($actor);
					}
				}
			$newPhp = '';

			if (count($applied))
				{
				$this->log('info', 'Printing ' . $file . ' Applied: ' . implode(', ', $applied));
				$newPhp = $this->printer->printFormatPreserving($newStmts, $oldStmts, $oldTokens);
				}

			}
		catch (\Throwable $e)
			{
			$this->log('error', "Error {$e->getMessage()} processing file {$file}");
			}

		return $newPhp;
	  }

	public function removeActor(\PHPFUI\RefActor\Actor $actor) : self
		{
		unset($this->actors[get_class($actor)]);

		return $this;
		}

	public function removeDirectory(string $directory) : self
		{
		unset($this->directories[$directory]);

		return $this;
		}

	public function removeFile(string $file) : self
		{
		unset($this->files[$file]);

		return $this;
		}

	/**
	 * Register a logger to get immediate feedback, or call getReviews after calling execute for all
	 * reviews so far.
	 */
	public function setLogger(?\Psr\Log\LoggerInterface $logger = null) : self
		{
		$this->logger = $logger;

		return $this;
		}

	/**
	 * What version of PHP should the parser expect. Default \PhpParser\ParserFactory::PREFER_PHP7
	 *
	 * Possible values:
   * - \PhpParser\ParserFactory::PREFER_PHP7
   * - \PhpParser\ParserFactory::PREFER_PHP5
   * - \PhpParser\ParserFactory::ONLY_PHP7
   * - \PhpParser\ParserFactory::ONLY_PHP5
	 */
	public function setPHPVersion(int $PHPVersion = \PhpParser\ParserFactory::PREFER_PHP7) : self
		{
		if ($PHPVersion < 1 || $PHPVersion > 4)
			{
			throw new \InvalidArgumentException(__METHOD__ . ': PHPVersion must be a \PhpParser\ParserFactory constant');
			}
		$this->PHPVersion = $PHPVersion;

		return $this;
		}

	/**
	 * If testing is turned on, no files will be written
	 */
	public function setTesting(bool $testing = false) : self
		{
		$this->testing = $testing;

		return $this;
		}

	/**
	 * Output the generated PHP code
	 */
	private function output(string $file, string $PHP) : self
		{
		if (! $this->testing)
			{
			file_put_contents($file, $PHP);
			}
		else
			{
			$this->tests[$file] = $PHP;
			}

		return $this;
		}

	}
