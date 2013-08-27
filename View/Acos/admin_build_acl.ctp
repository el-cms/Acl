<?php

echo $this->element('design/header');
?>

<?php

echo $this->element('Acos/links');
?>

<?php

if ($run) {
	if (count($logs) > 0) {
		echo '<p>';
		echo __d('acl', 'The following actions ACOs have been created');
		echo '<p>';
		echo $this->Html->nestedList($logs);
	} else {
		echo '<p>';
		echo __d('acl', 'There was no new actions ACOs to create');
		echo '</p>';
	}
} else {
	echo '<p>';
	echo __d('acl', 'This page allows you to build missing actions ACOs if any.');
	echo '</p>';

	if (count($missing_aco_nodes) > 0) {
		echo '<div class="row">';
		echo '<div class="col-lg-6">';
		echo '<h3>' . __d('acl', 'Missing ACOs') . '</h3>';

		echo '<p>';
		echo $this->Html->nestedList($missing_aco_nodes);
		echo '</p>';

		echo '</div>';
		echo '<div class="col-lg-6">';
		echo '<p>';
		echo $this->Html->link('<i class="icon-plus-sign"></i> ' . __d('acl', 'Build'), '/admin/acl/acos/build_acl/run', array('escape' => false, 'class' => 'btn btn-primary', 'escape' => false));
		echo ' ' . __d('acl', '(Clicking the link will not destroy existing actions ACOs.)');
		echo '</p>';
		echo '</div>';
		echo '</div>';
	} else {
		echo '<div class="alert alert-success">';
		echo '<i class="icon-ok"></i> ' . __d('acl', 'There is no ACO node to create');
		echo '</div>';
	}
}

echo $this->element('design/footer');
?>