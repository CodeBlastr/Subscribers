<?php
App::uses('MailAppModel', 'Mail.Model');

class MailSubscriber extends MailAppModel {
	
	public $name = 'MailSubscriber';
	
	public $displayField = 'email';
	
	public $validate = array(
		'email' => array('notempty')
		); 
		
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array(
		'Subscriber' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		);
	
}
