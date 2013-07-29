<?php
App::uses('Subscriber', 'Subscribers.Model');

/**
 * Subscriber Test Case
 *
 */
class SubscriberTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
        'plugin.Subscribers.Subscriber',
        );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Subscriber = ClassRegistry::init('Subscribers.Subscriber');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Subscriber);

		parent::tearDown();
	}
	
	
/**
 *
 */
	public function testSubscribers() {
		$result = $this->Subscriber->find('all');
		
	}

}
