<?php

namespace Example\View;

class Abide
	{
	/** @param array<string, string> $parameters */
	public function __construct(private \PHPFUI\Page $page, private array $parameters)
		{
		}

	public function render() : \PHPFUI\Container
		{
		$container = new \PHPFUI\Container();

		$requiredFields = new \PHPFUI\FieldSet('Required Fields');
		$name = new \PHPFUI\Input\Text('name', 'Full Name', $this->parameters['name'] ?? '');
		$name->setRequired();
		$name->setToolTip('Include salutation if desired');
		$email = new \PHPFUI\Input\Email('email', 'email', $this->parameters['email'] ?? '');
		$email->setRequired();
		$requiredFields->add(new \PHPFUI\MultiColumn($name, $email));

		$phone = new \PHPFUI\Input\Tel($this->page, 'phone', 'Phone', $this->parameters['phone'] ?? '');
		$phone->setRequired();
		$phone->setToolTip('Best contact phone, cell or landline');
		$zip = new \PHPFUI\Input\Zip($this->page, 'zip', 'Zip Code', $this->parameters['zip'] ?? '');
		$zip->setRequired();
		$requiredFields->add(new \PHPFUI\MultiColumn($phone, $zip));

		$password = new \PHPFUI\Input\PasswordEye('password', 'Password', $this->parameters['password'] ?? '');
		$password->setRequired();
		$password->setToolTip('Enter your password');
		$passwordConfirm = new \PHPFUI\Input\Password('passwordConfirm', 'Confirm Your Password', $this->parameters['passwordConfirm'] ?? '');
		$passwordConfirm->setRequired();
		$passwordConfirm->setToolTip('Enter your password from above again to confirm it is correct.');
		$passwordConfirm->addAttribute('data-equalto', $password->getId());
		$requiredFields->add(new \PHPFUI\MultiColumn($password, $passwordConfirm));

		$container->add($requiredFields);

		$optionalFields = new \PHPFUI\FieldSet('Suggested Fields');
		$date = new \PHPFUI\Input\Date($this->page, 'startDate', 'Start Date', $this->parameters['startDate'] ?? '');
		$time = new \PHPFUI\Input\Time($this->page, 'startTime', 'Start Time', $this->parameters['startTime'] ?? '');
		$state = new \Example\View\State($this->page, 'state', 'State of Residence', $this->parameters['state'] ?? '');
		$optionalFields->add(new \PHPFUI\MultiColumn($date, $time, $state));
		$movie = new \PHPFUI\Input\RadioGroup('movie', 'Favorite Movie Franchise', $this->parameters['movie'] ?? '');
		$movie->addButton('Star Wars', '1');
		$movie->addButton('Star Trek', '2');
		$movie->addButton('Monty Python', '3');
		$movie->addButton('Batman', '4');
		$optionalFields->add($movie);

		$file = new \PHPFUI\Input\File($this->page, 'resume', 'Upload Your Resume');
		$file->setAllowedExtensions(['doc', 'docx', 'pdf', 'odt', 'md', 'html']);
		$optionalFields->add($file);
		$container->add($optionalFields);

		$correct = new \PHPFUI\Input\CheckBox('correct', 'I certify the above information is correct', 1);
		$correct->setRequired();
		$container->add($correct);

		return $container;
		}
	}
