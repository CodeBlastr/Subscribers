<?php
App::uses('ModelBehavior', 'Model');

/**
 * Subscribable Behavior class file.
 *
 * A collection of methods to create objects that people are subscribed to getting notifications about. 
 * 
 * @filesource
 * @author			Richard Kersey
 * @copyright       Buildrr LLC
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link            https://github.com/zuha/Mail-Zuha-Cakephp-Plugin
 */
class SubscribableBehavior extends ModelBehavior {

/**
 * Behavior settings
 * 
 * @access public
 * @var array
 */
	public $settings = array();

/**
 * The full results of Model::find() that are modified and saved
 * as a new copy.
 *
 * @access public
 * @var array
 */
	public $record = array();

/**
 * Default values for settings.
 *
 * - recursive: whether to copy hasMany and hasOne records
 * - habtm: whether to copy hasAndBelongsToMany associations
 * - stripFields: fields to strip during copy process
 * - ignore: aliases of any associations that should be ignored, using dot (.) notation.
 * will look in the $this->contain array.
 *
 * @access private
 * @var array
 */
    protected $defaults = array(
		'modelAlias' => null, // changed to $Model->alias in setup()
		'foreignKeyName' => null,
		);
		
	public $modelName = '';
	
	public $foreignKey = '';


/**
 * Configuration method.
 *
 * @param object $Model Model object
 * @param array $config Config array
 * @access public
 * @return boolean
 */
    public function setup($Model, $config = array()) {
    	$this->settings = array_merge($this->defaults, $config);
		$this->modelName = !empty($this->settings['modelAlias']) ? $this->settings['modelAlias'] : $Model->alias;
		$this->foreignKey =  !empty($this->settings['foreignKeyName']) ? $this->settings['foreignKeyName'] : $Model->primaryKey;
		$this->MailSubscriber = ClassRegistry::init('Mail.MailSubscriber');
    	return true;
	}
	
/**
 * Subscribe method
 * 
 * Send one or many user ids, and one model / foreignkey to create a related subscription.
 * It would be nice if when you send that you include the email so we don't have to look it up. (If you have it already)
 * 
 * @return boolean
 * @todo we should probably do a check to see if the person is already subscribed before adding them
 */
 	public function subscribe($Model, $userIds) {
		if (is_array($userIds)) {
			for ($i = 1; $i <= count($userIds); $i++) {
				$data[$i]['MailSubscriber']['user_id'] = $userIds[$i];
				$data[$i]['MailSubscriber']['email'];
				
			}
			debug($data);
			debug('handle many subscribers at once here');
			break;
		} else {
			$userId = $userIds; // just one
			$data['MailSubscriber']['user_id'] = $userId;
			$data['MailSubscriber']['email'] = !empty($data['MailSubscriber']['email']) ? $data['MailSubscriber']['email'] : $this->MailSubscriber->Subscriber->field('email', array('Subscriber.id' => $userId));
			$data['MailSubscriber']['model'] = $this->modelName;
			$data['MailSubscriber']['foreign_key'] = $Model->data[$this->modelName][$this->foreignKey];
			$data['MailSubscriber']['is_active'] = 1;
		}
		if ($this->MailSubscriber->saveAll($data)) {
			return true;
		}
		return false;
 	}
	
/**
 * Subscribers method
 * 
 * Returns a list of subscribers in $array[n]['User] = array('email' => 'some@somewhere.com', 'name' => 'Their Name')); format
 */
 	public function subscribers(Model $Model, $data) {
 		$model = $this->modelName;
		$foreignKey = $data[$model][$this->$this->foreignKey];
		debug($model);
		debug($foreignKey);
		debug($this->MailSubscriber->find('all', array('conditions' => array('MailSubscriber.model' => $model, 'MailSubscriber.foreign_key' => $foreignKey))));
		break;
 	}
	
/**
 * Unsubscribe method
 * 
 * Set a subscribe to is_active = 0;
 * 
 */
 	public function unsubscribe(Model $Model, $data) {
 		break;
 	}
	
/**
 * Unsubscribed method
 * 
 * Return a list of people who were once subsribed to an object but at some point unsubscribed
 * 
 */
 	public function unsubscribed(Model $Model, $data) {
 		break;
 	}
}