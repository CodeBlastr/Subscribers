<?php
App::uses('MailAppController', 'Mail.Controller');
class MailSubscribersController extends MailAppController {

	public $name = 'MailSubscribers';
	
	public $uses = array('Mail.MailSubscriber');

}

