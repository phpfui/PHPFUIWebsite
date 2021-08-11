<?php

namespace PHPFUI\ConstantContact\Definition;

class BouncesTrackingActivity extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $contact_id The ID that uniquely identifies a contact.
	 * @var uuid $campaign_activity_id The ID that uniquely identifies the email campaign activity.
	 * @var string $tracking_activity_type The type of email tracking activity, <code>em_bounces</code>, that this report includes.
	 * @var string $email_address The contact's email address that was used when the email campaign activity bounced.
	 * @var string $first_name The first name of the contact.
	 * @var string $last_name The last name of the contact.
	 * @var string $bounce_code The one-character string used to specify the reason for the email bounce. Valid codes include:

<ul><li><code>B</code> - Non-existent address; the contact's Internet Service Provider (ISP) indicates that the email address doesn't exist.</li>

<li><code>D</code> - Undeliverable; after repeated delivery attempts, no response was received from the contact's ISP.</li>

<li><code>F</code> - Full; the contact's mailbox is full.</li>

<li><code>S</code> - Suspended; the contact's address was reported as non-existent by the ISP and is suspended from delivery.</li>

<li><code>V</code> - Vacation/autoreply; the contact set an autoreply, but the message was delivered.</li>

<li><code>X</code> - Other; the contact's ISP specified another reason that the message cannot be delivered.</li>

<li><code>Z</code> - Blocked; the recipient's ISP chose not to deliver the email. For example, the ISP may have flagged the email as spam.</li></ul>
	 * @var string $current_email_address The contact's most current email address. If <code>email_address</code> was updated after the email bounce activity occurred, <code>current_ email_address</code> displays the updated address. If updates were not made to <code>email_address</code>, the <code>email_address</code> and <code>current_email_address</code> are the same.
	 * @var date-time $created_time The date and time that the email bounce tracking activity occurred.
	 * @var date $deleted_at If applicable, the date when the contact was deleted.
	 */

	protected static array $fields = [
		'contact_id' => 'uuid',
		'campaign_activity_id' => 'uuid',
		'tracking_activity_type' => 'string',
		'email_address' => 'string',
		'first_name' => 'string',
		'last_name' => 'string',
		'bounce_code' => 'string',
		'current_email_address' => 'string',
		'created_time' => 'date-time',
		'deleted_at' => 'date',

	];
	}