<?php

namespace Example;

class ComposerVersion extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct([$this, 'processPost']);

		$this->addBody(new \PHPFUI\Header('Composer Version Checker'));
		$form = new \PHPFUI\Form($this);
		$parameters = \PHPFUI\Session::getFlash('post');

		if ($parameters)
			{
			$parameters = json_decode($parameters, true);
			}
		else
			{
			$parameters = [];
			}

		$view = new \Example\View\ComposerVersion($this, $parameters);
		$form->add($view->render());
		$form->add(new \PHPFUI\Submit('Test', 'save'));
		$this->addBody($form);
		}

	public function processPost(array $post) : void
		{
		\PHPFUI\Session::setFlash('post', json_encode($_POST));
		$version = $post['version'] ?? '';
		$constraint = $post['constraint'] ?? '';
		if (! $constraint || ! $version)
			{
			\PHPFUI\Session::setFlash('alert', json_encode('constraint and / or version field not found'));

			return;
			}

		try
			{
			if (\Composer\Semver\Semver::satisfies($version, $constraint))
				{
				\PHPFUI\Session::setFlash('success', json_encode("Version '<b>{$version}</b>' satifies constraint '<b>{$constraint}</b>'"));

				return;
				}
			}
		catch (\Throwable $e)
			{
			\PHPFUI\Session::setFlash('alert', json_encode($e->getMessage()));

			return;
			}

		\PHPFUI\Session::setFlash('warning', json_encode("Version '<b>{$version}</b>' is not allowed for constraint '<b>{$constraint}</b>'"));
		}

	}

