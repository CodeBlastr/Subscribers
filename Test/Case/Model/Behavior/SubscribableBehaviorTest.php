<?php
/* Subscribable Test */
App::uses('SubscribableBehavior', 'Subscribers.Model/Behavior');

if (!class_exists('SubscriberArticle')) {
	class SubscriberArticle extends CakeTestModel {
	/**
	 *
	 */
		public $callbackData = array();

	/**
	 *
	 */
		public $actsAs = array(
			'Subscribers.Subscribable'
			);
	/**
	 *
	 */
		public $useTable = 'subscriber_articles';

	/**
	 *
	 */
		public $name = 'SubscriberArticle';
	/**
	 *
	 */
		public $alias = 'SubscriberArticle';
		
		public function afterSave() {
			// we say in the model when people get subscribed
			$this->subscribe($this->data['SubscriberArticle']['creator_id']);
		}
	}
}


/**
 * SubscribableBehavior Test Case
 *
 */
class SubscribableBehaviorTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Condition',
		'plugin.Users.User',
		'plugin.Subscribers.Subscribe',
		'plugin.Subscribers.SubscriberArticle',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//$this->Subscribable = new SubscribableBehavior();
		$this->SubscriberArticle = ClassRegistry::init('SubscriberArticle');
		$this->Subscriber = ClassRegistry::init('Subscribers.Subscriber');
	}

/**
 * tearDown method
 *
 * @return void
 */
    public function tearDown() {
		//unset($this->Draftable);
		unset($this->SubscriberArticle);
		unset($this->Subscriber);
		ClassRegistry::flush();

		parent::tearDown();
	}
	

/**
 * Test behavior instance
 *
 * @return void
 */
	public function testBehaviorInstance() {
		$this->assertTrue(is_a($this->SubscriberArticle->Behaviors->Subscribable, 'SubscribableBehavior'));
	}
	
/**
 * Test adding an article and subscribing the adder to that article
 */ 
	public function testAdding() {
		$before = count($this->Subscriber->find('all'));
		$data['SubscriberArticle'] = array(
			'title' => 'My New Article',
			'content' => 'Hello world!',
			'creator_id' => '100'
			);
		$this->SubscriberArticle->save($data);
		$after = count($this->Subscriber->find('all'));
		
		$this->assertTrue($after > $before);
	}

}
