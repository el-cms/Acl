<?php

echo $this->element('design/header');
?>

<?php

echo $this->element('Acos/links');
?>

<?php

echo '<p>';
echo __d('acl', 'This page allows you to clear all actions ACOs.');
echo '</p>';

if ($actions_exist) {
	echo '<div class="alert alert-warning">';
	echo $this->Html->link('<i class="fa fa-trash-o"></i> ' . __d('acl', 'Clear ACOs'), '/admin/acl/acos/empty_acos/run', array('confirm' => __d('acl', 'Are you sure you want to destroy all existing ACOs ?'), 'class' => 'btn btn-danger', 'escape' => false));
	echo ' ' . __d('acl', 'Clicking the link will destroy all existing actions ACOs and associated permissions.');
	echo '</div>';
} else {
	echo '<div class="alert alert-info">';
	echo __d('acl', 'There is no ACO node to delete');
	echo '</div>';
}

echo $this->element('design/footer');
?>