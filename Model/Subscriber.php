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
	
}
