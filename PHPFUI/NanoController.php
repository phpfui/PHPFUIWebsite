<?php

namespace PHPFUI;

class NanoController
	{

	private string $rootNamespace;
	private array $get;
	private array $post;
	private array $files;
	private string $missingClass;
	private string $missingMethod;
	private array $errors = [];

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

		if (isset($_GET))
			{
			$this->get = $_GET;
			}
		if (isset($_POST))
			{
			$this->post = $_POST;
			}
		if (isset($_FILES))
			{
			$this->files = $_FILES;
			}
		}

	public function setRootNamespace(string $namespace = 'App') : self
		{
		$this->rootNamespace = $namespace;

		return $this;
		}

	public function run() : object
		{
		/**
		 * Iterate through uri looking for a lowercase letter
		 * Lower case letter indicates a method name
		 * look at previous
		 */
		$urlParts = parse_url($_SERVER['REQUEST_URI']);
		$parts = explode('/', $urlParts['path']);
		array_shift($parts);
		$class = explode('\\', $this->rootNamespace);
		foreach ($parts as $index => $method)
			{
			if (strlen($method) && ctype_lower($method[0]))
				{
				$classObject = $this->invokeClassMethod($class, $method, $parts, $index);
				if ($classObject)
					{
					return $classObject;
					}
				else
					{
					return $this->punt($class);
					}
				}
			elseif (! ctype_alpha($parts[0]))
				{
				// not alpha start, need to punt
				return $this->punt($class);
				}
			// add the part the class
			$class[] = $method;
			}

		return $this->punt($class);
		}

	private function invokeClassMethod(array $class, string $method, array $parts = [], int $index = 0) : ?object
		{
		$className = implode('\\', $class);
		// if we are at the rool namespace, we are done
		if ($className == $this->rootNamespace)
			{
			return null;
			}

		// should have method name and class, try to invoke
		if (! class_exists($className))
			{
			$this->errors['Class ' . $className . ' does not exist'] = true;

			return null;
			}

		if (! method_exists($className, $method))
			{
			$this->errors['Class Method ' . $className . '::' . $method . ' does not exist'] = true;

			return null;
			}

		$classObject = new $className($this);
		$reflection = new \ReflectionClass($classObject);
		$reflectionMethod = $reflection->getMethod($method);
		$args = ($index + 1) < count($parts) ? array_slice($parts, $index + 1) : [];
		$numberArgs = count($args);
		$argNumber = 0;
		foreach ($reflectionMethod->getParameters() as $parameter)
			{
			if ($argNumber >= $numberArgs)
				{
				break;
				}
			$arg = $args[$argNumber];
			if ($parameter->hasType())
				{
				$type = $parameter->getType();
				$parameterType = $type->getName();
				if ($type->isBuiltIn())
					{
					switch ($type->getName())
						{
						case 'array': // remaining arguments are put into this parameter and processing stops
							$arg = array_slice($args, $argNumber);
							$args = array_slice($args, 0, $argNumber);
							$argNumber = $numberArgs;
							break;
						case 'bool':
							$arg = (bool)$arg;
							break;
						case 'int':
							$arg = (int)$arg;
							break;
						case 'float':
							$arg = (float)$arg;
							break;
						}
					}
				else
					{
					$arg = new $parameterType($arg);
					}
				}
			$args[$argNumber++] = $arg;
			}
		$reflectionMethod->invokeArgs($classObject, $args);

		return $classObject;
		}

	/**
	 * We can't find a Class\Method pair, so just find a class and check if it has a landing page if defined, else, just construct the class and return.
	 */
	private function punt(array $classParts) : object
		{
		while (count($classParts))
			{
			$className = implode('\\', $classParts);
			// if we are at the rool namespace, we are done
			if ($className == $this->rootNamespace)
				{
				break;
				}

			if ($this->missingMethod)
				{
				$classObject = $this->invokeClassMethod($classParts, $this->missingMethod);
				if ($classObject)
					{
					return $classObject;
					}
				}
			array_pop($classParts);
			}

		return new $this->missingClass($this);
		}

	/**
	 * If no class is found in the URL, return an instance of this class.
	 */
	public function setMissingClass(string $missingClass = 'App\\Missing') : self
		{
		$this->missingClass = $missingClass;

		return $this;
		}

	/**
	 * If a class is found, but a method is not, then return the missing method. If no missing method is defined, then the missing class constructor is called
	 */
	public function setMissingMethod(string $missingMethod = '') : self
		{
		$this->missingMethod = $missingMethod;

		return $this;
		}

	public function getGet() : array
		{
		return $this->get;
		}

	public function setGet(array $get = []) : self
		{
		$this->get = $get;

		return $this;
		}

	public function getPost() : array
		{
		return $this->post;
		}

	public function setPost(array $post = []) : self
		{
		$this->post = $post;

		return $this;
		}

	public function getFiles() : array
		{
		return $this->files;
		}

	public function setFiles(array $files = []) : self
		{
		$this->files = $files;

		return $this;
		}

	public function getErrors() : array
		{
		return array_keys($this->errors);
		}

	}
