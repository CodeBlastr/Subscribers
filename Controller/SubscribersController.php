<?php
App::uses('SubscribersAppController', 'Subscribers.Controller');
class SubscribersController extends SubscribersAppController {

	public $name = 'Subscribers';
	
	public $uses = array('Subscribers.Subscriber');

}

