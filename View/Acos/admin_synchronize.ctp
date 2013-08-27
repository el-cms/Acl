<?php

echo $this->element('design/header');
?>

<?php

echo $this->element('Acos/links');
?>

<?php

if ($run) {
	echo '<div class="row">';
	echo '<div class="col-lg-6">';
	echo '<h3>' . __d('acl', 'New ACOs') . '</h3>';
	if (count($create_logs) > 0) {
		echo '<p>';
		echo __d('acl', 'The following actions ACOs have been created');
		echo '<p>';
		echo $this->Html->nestedList($create_logs);
	} else {
		echo '<div class="alert alert-info">';
		echo __d('acl', 'There was no new actions ACOs to create');
		echo '</div>';
	}
	echo '</div>';
	echo '<div class="col-lg-6">';
	echo '<h3>' . __d('acl', 'Obsolete ACOs') . '</h3>';

	if (count($prune_logs) > 0) {
		echo '<p>';
		echo __d('acl', 'The following actions ACOs have been deleted');
		echo '<p>';
		echo $this->Html->nestedList($prune_logs);
	} else {
		echo '<div class="alert alert-info">';
		echo __d('acl', 'There was no action ACO to delete');
		echo '</div>';
	}
	echo '</div>';
	echo '</div>';
} else {
	echo '<p>';
	echo __d('acl', 'This page allows you to synchronize the existing controllers and actions with the ACO datatable.');
	echo '</p>';

	$has_aco_to_sync = false;
	echo '<div class="row">';
	echo '<div class="col-lg-4">';
	echo '<h3>' . __d('acl', 'Missing ACOs') . '</h3>';
	if (count($missing_aco_nodes) > 0) {
		echo '<p>';
		echo $this->Html->nestedList($missing_aco_nodes);
		echo '</p>';

		$has_aco_to_sync = true;
	}
	echo '<div class="alert alert-info">';
		echo '<i class="icon-info-sign"></i> '. __d('acl', 'There is no missing ACO.');
		echo '</div>';
	echo '</div>';

	echo '<div class="col-lg-4">';
	echo '<h3>' . __d('acl', 'Obsolete ACO nodes') . '</h3>';
	if (count($nodes_to_prune) > 0) {
		echo '<p>';
		echo $this->Html->nestedList($nodes_to_prune);
		echo '</p>';

		$has_aco_to_sync = true;
	}
	else{
		echo '<div class="alert alert-info">';
		echo '<i class="icon-info-sign"></i> '. __d('acl', 'There is no ACO to prune.');
		echo '</div>';
	}
	echo '</div>';

	echo '<div class="col-lg-4">';
	echo '<h3>' . __d('acl', 'Synchronize') . '</h3>';
	if ($has_aco_to_sync) {
		echo '<p>';
		echo $this->Html->link('<i class="icon-refresh"></i> ' . __d('acl', 'Synchronize'), '/admin/acl/acos/synchronize/run', array('class'=>'btn btn-primary','escape' => false));
		echo ' ' . __d('acl', 'Clicking the link will not change or remove permissions for existing actions ACOs.');
		echo '</p>';
	} else {
		echo '<div class="alert alert-success">';
		echo '<i class="icon-info-sign"></i> ' . __d('acl', 'The ACO datatable is already synchronized');
		echo '</div>';
	}
	echo '</div>';

	echo '</div>';
}

echo $this->element('design/footer');
?>