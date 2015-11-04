<?php
App::uses('SubscribersAppController', 'Subscribers.Controller');
class SubscribersController extends SubscribersAppController {

	public $name = 'Subscribers';
	
	public $uses = array('Subscribers.Subscriber');
	
	public $allowedActions = array('unsubscribe');
	
	public function subscribe() {
 		if ($this->request->is('post')) {
 			try {
 				// the data that should be coming in
 				// $data['Subscriber']['user_id'] = ;
				// $data['Subscriber']['email'] = ;
				// $data['Subscriber']['model'] = ;
				// $data['Subscriber']['foreign_key'] = ;
				$this->Session->setFlash(__('Successful Subscription')); 
 				$this->Subscriber->subscribe($this->request->data);
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		} else {
			$this->Session->setFlash('Invalid request');
		}
		$this->redirect($this->referer());
	}
	
	public function unsubscribe($subscriptionId = null) {
		$data['Subscriber']['id'] = $subscriptionId;
		$data['Subscriber']['is_active'] = 0;
		if ($this->Subscriber->save($data)) {
			$this->Session->setFlash(__('Successfully Unsubscribed'));
		} else {
			$this->Session->setFlash(__('Error with unsubscribing, please try again.'));
		}
		$this->redirect($this->referer());
	}

}

