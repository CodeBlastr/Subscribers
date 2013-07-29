<?php
App::uses('MailSubscribe', 'Mail.Model');

/**
 * Project Test Case
 *
 */
class MailSubscriberTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
        'plugin.Mail.MailSubscriber',
        );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MailSubscriber = ClassRegistry::init('Mail.MailSubscriber');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MailSubscriber);

		parent::tearDown();
	}
	
	
/**
 *
 */
	public function testSubscribers() {
		$result = $this->MailSubscriber->find('all');
		debug($result);
		break;
	}

}
