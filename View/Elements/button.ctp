<?php if (!empty($model) && !empty($foreignKey)) : ?>
	<?php $subscribeButton = array('label' => 'monkey'); ?>
	<?php $SubscriberHelper = $this->Helpers->load('Subscribers.Subscriber'); ?>
	<?php // was going to put this find into a function directly in the helper, but I think it's light enough not to need to do that ?>
	<?php $subscription = $SubscriberHelper->find('first', array('conditions' => array('Subscriber.is_active' => 1, 'Subscriber.user_id' => $this->Session->read('Auth.User.id'), 'Subscriber.model' => $model, 'Subscriber.foreign_key' => $foreignKey))); ?>
	<?php if (empty($subscription)) : ?>
		<?php echo $this->Form->create('Subscriber', array('type' => 'post', 'url' => array('plugin' => 'subscribers', 'controller' => 'subscribers', 'action' => 'subscribe'))); ?>
			<?php echo $this->Form->hidden('Subscriber.user_id', array('value' => $this->Session->read('Auth.User.id'))); ?>
			<?php echo $this->Form->hidden('Subscriber.model', array('value' => $model)); ?>
			<?php echo $this->Form->hidden('Subscriber.foreign_key', array('value' => $foreignKey)); ?>
			<?php echo $this->Form->button('Subscribe', array('type' => 'submit', 'class' => 'btn btn-default', 'label' => 'test')); ?>
		<?php echo $this->Form->end(); ?>
	<?php else : ?>
		<?php echo $this->Html->link('Unsubscribe from New Posts', array('plugin' => 'subscribers', 'controller' => 'subscribers', 'action' => 'unsubscribe', $subscription['Subscriber']['id']), array('class' => 'btn btn-default')); ?>
	<?php endif; ?>
<?php else : ?>
	model and foreign required for subscribe button
<?php endif; ?>