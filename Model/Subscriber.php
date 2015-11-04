<?php
App::uses('SubscribersAppModel', 'Subscribers.Model');

class Subscriber extends SubscribersAppModel {
	
	public $name = 'Subscriber';
	
	public $displayField = 'name';
	
	public $validate = array(); 
		
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		);

/**
 * Subscribe method
 * 
 * @param mixed $data 
 */
	public function subscribe($data = array()) {
		if (is_array($data)) {
			if (!empty($data[0]['Subscriber'])) {
				// handle multiple subscribers
				for ($i = 1; $i <= count($data); $i++) {
					$subscriber['Subscriber']['user_id'];
					$subscriber['Subscriber']['email'];
					// something like : $this->subscribe($Model, $subscriber);  // a call to itself for the save
				}
				debug($subscriber);
				debug('handle many subscribers at once here');
				// something like $this->subscribe($Model, $)
				break;
			} else {
				// handle a single subscriber 
				$email = !empty($subscriber['Subscriber']['email']) ? $subscriber['Subscriber']['email'] : $this->User->field('email', array('User.id' => $data['Subscriber']['user_id']));
				$userId = $data['Subscriber']['user_id'];
				$subscriber['Subscriber']['email'] =  !empty($email) ? $email : null;
				$modelName = !empty($data['Subscriber']['model']) ? $data['Subscriber']['model'] : $this->modelName;
				$foreignKey = $data['Subscriber']['foreign_key'] ? $data['Subscriber']['foreign_key'] : $Model->data[$this->modelName][$this->foreignKey];
			}
		} else {
			// just a single user id coming in
			$userId = $data;
			$email = $this->User->field('email', array('User.id' => $userId));
			$modelName = $this->modelName;
			$foreignKey = $Model->data[$this->modelName][$this->foreignKey];
		}

		// finalize the data before saving
		$subscriber['Subscriber']['user_id'] = $userId;
		$subscriber['Subscriber']['email'] = !empty($email) ? $email : null;
		$subscriber['Subscriber']['model'] = $modelName;
		$subscriber['Subscriber']['foreign_key'] = $foreignKey;
		$subscriber['Subscriber']['is_active'] = 1;
		$subscriber['Subscriber']['id'] = $this->checkSubscriber($subscriber);
		
		$this->create();
		if ($this->save($subscriber)) {
			return true;
		}
		throw new Exception(__('Failed to subscribe, please try again.'));
	}

/**
 * Check Subscriber method
 * 
 * Determine whether a user is, or is not already subscribed to the model/foreign_key provided
 * 
 * @param array
 * @return uuid, null (id if inactive, null if not subscribed, so that you can resubsribe if inactive or create a new subscription if null)
 */
	public function checkSubscriber($data = array()) {
		$subscription = $this->find('first', array('conditions' => array(
			'OR' => array(
				'Subscriber.user_id' => $data['Subscriber']['user_id'],
				'Subscriber.email' => $data['Subscriber']['email']
				),
			'Subscriber.model' => $data['Subscriber']['model'],
			'Subscriber.foreign_key' => $data['Subscriber']['foreign_key']
			)));
		if ($subscription['Subscriber']['is_active'] == 0) {
			return $subscription['Subscriber']['id']; // 
		} elseif (!empty($subscription)) {
			throw new Exception(__('You are already subscribed to this list.'));
		} else {
			return null;
		}
	}
	
}
