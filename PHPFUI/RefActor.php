<?php

namespace PHPFUI;

class RefActor implements \PHPParser\ErrorHandler
	{

	// Settings
	private int $PHPVersion;

	// user parameters
	private array $directories = [];

	private array $files = [];

	private array $actors = [];

	// internal properties
	private $parser;

	private ?\Psr\Log\LoggerInterface $logger;

	private array $reviews = [];

	private string $currentFile;

	public function __construct()
		{
		// initialize all the parameters to defaults
		$reflection = new \ReflectionClass($this);
		$methods = $reflection->getMethods();
		foreach ($methods as $method)
			{
			$name = $method->name;
			if (strpos($name, 'set') === 0)
				{
				// call the set function with default parameters
				$this->$name();
				}
			}
		$factory = new \PhpParser\ParserFactory();
		$this->parser = $factory->create($this->PHPVersion);
		}

	/**
	 * What version of PHP should the parse expect. Default \PhpParser\ParserFactory::PREFER_PHP7
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
	 * Directories are processed in order of adding, then files by OS order defined by DirectoryIterator
	 */
	public function addDirectory(string $directory, bool $recurseIntoDirectories = true, array $fileExtensions = ['.php']) : self
		{
		$this->directories[$directory] = ['recurse' => $recurseIntoDirectories, 'ext' => $fileExtensions];

		return $this;
		}

	public function removeDirectory(string $directory) : self
		{
		unset($this->directories[$directory]);

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

	public function removeFile(string $file) : self
		{
		unset($this->files[$file]);

		return $this;
		}

	/**
	 * Actors are processed in order of addition for each file processed.
	 */
	public function addActor(\PHPFUI\RefActor\Actor $actor) : self
		{
		$this->actors[get_class($actor)] = $actor;

		return $this;
		}

	public function removeActor(\PHPFUI\RefActor\Actor $actor) : self
		{
		unset($this->actors[get_class($actor)]);

		return $this;
		}

	/**
	 * Start RefActoring with the current settings
	 */
	public function execute() : self
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
				if ($item->getType() == 'file')
					{
					$file = $item->getPathname();
					$ext = strrchr($file, '.');
					if (! $ext)
						{
						continue;
						}
					if (isset($extensions[$ext]))
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

	private function log(string $type, string $message, array $context = []) : self
		{
		$this->reviews[$type][] = $message;

		if ($this->logger)
			{
			$this->logger->$type($message, $context);
			}

		return $this;
		}

	public function processFile(string $file) : self
		{
	  if (! file_exists($file))
		  {
			$this->log('error', __METHOD__ . ": File {$file} not found");

			return $this;
		  }

		$this->currentFile = $file;
		$this->log('info', __METHOD__ . ': Start processing ' . $file);

		$php = file_get_contents($file);

		$ast = $this->parser->parse($php, $this);

		foreach ($this->actors as $name => $actor)
			{
			$this->log('debug', __METHOD__ . ': Running Actor ' . $name);
			}

		$this->log('info', __METHOD__ . ': Done processing ' . $file);

		return $this;
	  }

	public function clearReviews() : self
		{
		$this->reviews = [];

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
	 * Reveiws are crituques of Actors, generally errors, warnings, etc.
	 *
	 * @param string $type literal of the method names from \Psr\Log\LoggerInterface or empty for all
	 *
	 * @return [$type][]
	 */
	public function getReviews(string $type = '') : array
		{
		if (empty($type))
			{
			return $this->reviews;
			}

		$reflection = new \ReflectionClass(\Psr\Log\LoggerInterface::class);
		try
			{
			$reflection->getMethod($type);
			}
		catch (\Throwable $e)
			{
			return ['error' => [__METHOD__ . ": {$type} is not a valid review type"]];
			}

		return [$type => $this->reviews[$type] ?? []];
		}

	public function handleError(\PHPParser\Error $error)
		{
		$line = $error->getStartLine() != -1 ? 'Line: ' . $error->getStartLine() : '';
		$this->log('error', "PHPParser error: {$error->getRawMessage()} in file {$this->currentFile} {$line}");
		}

	}
