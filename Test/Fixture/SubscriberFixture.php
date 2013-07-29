<?php

class SubscriberFixture extends CakeTestFixture {
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Subscribers.Subscriber');

/**
 * records property
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '107f267d-b9a0-4f4f-8294-09a545a3a941',
			'email' => 'someone@example.com',
			'user_id' => '100',
			'model' => 'MailArticle',
			'foreign_key' => 'a07f267d-b9a0-4f4f-8294-09a545a3a94z',
			'is_active' => 1,
			'creator_id' => '100',
			'modifier_id' => '100',
			'created' => '2012-12-22 00:00:00',
			'modified' => '2012-12-22 00:00:00',
		),
	);
}
