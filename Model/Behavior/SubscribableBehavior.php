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
 * @link            https://github.com/zuha/Subscribers-Zuha-Cakephp-Plugin
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
		$this->Subscriber = ClassRegistry::init('Subscribers.Subscriber');
    	return true;
	}


/**
 * afterSave is called after a model is saved.
 * We use this to subscribe users automatically when they create an account
 *
 * @param Model $Model Model using this behavior
 * @param boolean $created True if this save created a new record
 * @return boolean
 */
	public function afterSave(Model $Model, $created, $options = array()) {
		// create a subscription to particular model foreignKey combinations automatically upon user creation
		if ($created && $Model->name == 'User') { // might not need this model->name thing in the future, but couldn't envision any use besides user creation at the time of creating this setting
			if (defined('__SUBSCRIBERS_AUTO_SUBSCRIBE')) {
				$subscriptions = unserialize(__SUBSCRIBERS_AUTO_SUBSCRIBE);
				foreach ($subscriptions as $model => $foreignKeys) {
					$data['Subscriber']['user_id'] = $Model->id;
					$data['Subscriber']['model'] = $model;
					foreach ($foreignKeys as $foreignKey) {
						$data['Subscriber']['foreign_key'] = $foreignKey;
						$this->subscribe($Model, $data);
						unset($data);
					}
				}
			}
		}
		return parent::afterSave($Model, $created, $options);
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
 	public function subscribe($Model, $data) {
 		return $this->Subscriber->subscribe($data);
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
		debug($this->Subscriber->find('all', array('conditions' => array('Subscriber.model' => $model, 'Subscriber.foreign_key' => $foreignKey))));
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