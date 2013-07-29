<?php

class MailArticleFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string
 */
	public $name = 'MailArticle';

/**
 * fields property
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'), 		
		'title' => array('type' => 'string', 'null' => false),
		'content' => array('type' => 'string', 'null' => false),
		'creator_id' => array('type' => 'string', 'length' => 36, 'null' => false),
		);

/**
 * records property
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '4f88970e-b438-4b01-8740-1a14124e0d46', 
		  	'title' => 'One Article', 
		  	'content' => 'Lorem ipsum dolor sit am.',
		  	'creator_id' => '100',
			),
		array(
			'id' => '4f889729-c2fc-4c8a-ba36-1a14124e0d46', 
			'title' => 'Two Article', 
			'content' => 'Lorem ipsum dolor sit amet.',
		  	'creator_id' => '100',
			),
		array(
			'id' => '4f668729-c2fc-4c8a-ba36-1a14124e0d46', 
			'title' => 'Three Article', 
			'content' => 'Lorem ipsum dolor sit amet, aliquet.',
		  	'creator_id' => '100',
			),
		);
}
