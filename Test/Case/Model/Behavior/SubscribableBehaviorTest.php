<?php
/* Subscribable Test */
App::uses('SubscribableBehavior', 'Mail.Model/Behavior');

if (!class_exists('MailArticle')) {
	class MailArticle extends CakeTestModel {
	/**
	 *
	 */
		public $callbackData = array();

	/**
	 *
	 */
		public $actsAs = array(
			'Mail.Subscribable'
			);
	/**
	 *
	 */
		public $useTable = 'mail_articles';

	/**
	 *
	 */
		public $name = 'MailArticle';
	/**
	 *
	 */
		public $alias = 'MailArticle';
		
		public function afterSave() {
			// we say in the model when people get subscribed
			$this->subscribe($this->data['MailArticle']['creator_id']);
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
		'plugin.Mail.MailSubscribe',
		'plugin.Mail.MailArticle',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//$this->Subscribable = new SubscribableBehavior();
		$this->MailArticle = new MailArticle;
		$this->MailSubscriber = new MailSubscriber;
	}

/**
 * tearDown method
 *
 * @return void
 */
    public function tearDown() {
		//unset($this->Draftable);
		unset($this->MailArticle);
		unset($this->MailSubscriber);
		ClassRegistry::flush();

		parent::tearDown();
	}
	

/**
 * Test behavior instance
 *
 * @return void
 */
	public function testBehaviorInstance() {
		$this->assertTrue(is_a($this->MailArticle->Behaviors->Subscribable, 'SubscribableBehavior'));
	}
	
/**
 * Test adding an article and subscribing the adder to that article
 */ 
	public function testAdding() {
		$before = count($this->MailSubscriber->find('all'));
		$data['MailArticle'] = array(
			'title' => 'My New Article',
			'content' => 'Hello world!',
			'creator_id' => '100'
			);
		$this->MailArticle->save($data);
		$after = count($this->MailSubscriber->find('all'));
		
		$this->assertTrue($after > $before);
	}

}
