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
		
		public function afterSave($created) {
			if ($created) {
				// we say in the model when people get subscribed
				$this->subscribe($this->data['SubscriberArticle']['creator_id']);
			}
		}
		
		// used to subscribe to the parent on an edit
		public function articleEdit($data) {
			$result = null;
			if ($result = parent::save($data)) {
				$subscriber['Subscriber']['model'] = 'SubscriberArticle';
				$subscriber['Subscriber']['foreign_key'] = $data['SubscriberArticle']['id'];
				$subscriber['Subscriber']['user_id'] = $data['SubscriberArticle']['modifier_id'];
				$this->subscribe($subscriber);
			}
			return $result;
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
        'plugin.Subscribers.Subscriber',
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
 * Test adding a single subscriber to the parent model record
 */ 
	public function testSubscribe() {
		$before = $this->Subscriber->find('count');
		$data['SubscriberArticle'] = array(
			'title' => 'My New Article',
			'content' => 'Hello world!',
			'creator_id' => '100'
			);
		$this->SubscriberArticle->save($data);
		$after = $this->Subscriber->find('count');
		$this->assertTrue($after > $before);
	}

/**
 * Test adding an data[Subscriber][user_id] type of array
 */
 	public function testSubscribers() {
 		$before = $this->Subscriber->find('count');
		
		$data = $this->SubscriberArticle->find('first');
		$data['SubscriberArticle']['content'] = 'This is an update, so I want to subscribe';  // eg. notify me and the owner of changes to the article
		$data['SubscriberArticle']['modifier_id'] = '101';
		
		$result = $this->SubscriberArticle->articleEdit($data);	
		$after = $this->Subscriber->find('count');
		$this->assertTrue($after > $before);
 	}

}
