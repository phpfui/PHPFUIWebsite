<?php

namespace Example\View;

class ComposerVersion
	{
	// @phpstan-ignore-next-line
	public function __construct(private \PHPFUI\Page $page, private array $parameters)
		{
		}

	public function render() : \PHPFUI\Container
		{
		$container = new \PHPFUI\Container();

		$callout = new \PHPFUI\Callout('secondary');
		$semver = new \PHPFUI\Link('https://github.com/composer/semver', 'Composer/Semver');
		$packagist = new \PHPFUI\Link('https://packagist.org/', 'Packagist.org');
		$rules = new \PHPFUI\Link('https://getcomposer.org/doc/articles/versions.md', 'here');
		$callout->add("Getting Composer constraints are often not obvious. This form uses the same {$semver}
									library to test version constraints so you won't be surprised when you upload to {$packagist}.
									You can find all the Composer version rules {$rules}.");
		$container->add($callout);

		$requiredFields = new \PHPFUI\FieldSet('Required Fields');
		$constraint = new \PHPFUI\Input\Text('constraint', 'Composer Constraint String', $this->parameters['constraint'] ?? '');
		$constraint->setRequired();
		$constraint->setToolTip('This is the version constraint directly from your composer.json file. Example: ^7.2 | <8.1');
		$requiredFields->add($constraint);
		$version = new \PHPFUI\Input\Text('version', 'Version To Test', $this->parameters['version'] ?? '');
		$version->setRequired();
		$version->setToolTip('This is the version you want to test to see if the constraint does what you want. Example: 7.4.13');
		$requiredFields->add($version);

		$container->add($requiredFields);

		return $container;
		}
	}
