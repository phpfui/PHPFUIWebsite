<?php

namespace PHPFUI\ConstantContact\Definition;

class ContactCreateOrUpdateInput extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $email_address The email address for the contact. This method identifies each unique contact using their email address. If the email address exists in the account, this method updates the contact. If the email address is new, this method creates a new contact.
	 * @var string $first_name The first name of the contact.
	 * @var string $last_name The last name of the contact.
	 * @var string $job_title The job title of the contact.
	 * @var string $company_name The name of the company where the contact works.
	 * @var string $phone_number The phone number for the contact.
	 * @var array $list_memberships The contact lists you want to add the contact to as an array of up to 50 contact <code>list_id</code> values. You must include at least one <code>list_id</code>.
	 * @var array $custom_fields The custom fields you want to add to the contact as an array of up to 50 custom field objects.
	 * @var string $anniversary The anniversary date for the contact. For example, this value could be the date when the contact first became a customer of an organization in Constant Contact. Valid date formats are MM/DD/YYYY, M/D/YYYY, YYYY/MM/DD, YYYY/M/D, YYYY-MM-DD, YYYY-M-D,M-D-YYYY, or M-DD-YYYY.
	 * @var int $birthday_month The month value for the contact's birthday. Valid values are from 1 through 12. The <code>birthday_month</code> property is required if you use <code>birthday_day</code>.
	 * @var int $birthday_day The day value for the contact's birthday. Valid values are from 1 through 31. The <code>birthday_day</code> property is required if you use <code>birthday_month</code>.
	 */

	protected static array $fields = [
		'email_address' => 'string',
		'first_name' => 'string',
		'last_name' => 'string',
		'job_title' => 'string',
		'company_name' => 'string',
		'phone_number' => 'string',
		'list_memberships' => 'array',
		'custom_fields' => 'array',
		'anniversary' => 'string',
		'birthday_month' => 'int',
		'birthday_day' => 'int',
		'street_address' => 'PHPFUI\\ConstantContact\\Definition\\StreetAddress',

	];

	protected static array $maxLength = [
		'email_address' => 50,
		'first_name' => 50,
		'last_name' => 50,
		'job_title' => 50,
		'company_name' => 50,
		'phone_number' => 25,

	];
	}