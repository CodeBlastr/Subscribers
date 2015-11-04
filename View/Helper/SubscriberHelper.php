<?php
/**
 * Subscriber helper
 *
 * @package 	subscribers
 * @subpackage 	subscribers.views.helpers
 */
class SubscriberHelper extends AppHelper {

/**
 * helpers variable
 *
 * @var array
 */
	public $helpers = array ('Html', 'Form', 'Js' => 'Jquery');

/**
 * Constructor method
 * 
 */
    public function __construct(View $View, $settings = array()) {
    	$this->View = $View;
    	//$this->defaults = array_merge($this->defaults, $settings);
		parent::__construct($View, $settings);
		App::uses('Subscriber', 'Subscribers.Model');
		$this->Subscriber = new Subscriber();
    }

/**
 * Find method
 */
 	public function find($type = 'first', $params = array()) {
 		return $this->Subscriber->find($type, $params);
 	}

}