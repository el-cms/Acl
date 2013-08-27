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
		echo __d('acl', 'The following actions ACOs have been pruned');
		echo '<p>';
		echo $this->Html->nestedList($logs);
	} else {
		echo '<div class="alert alert-info">';
		echo '<i class="icon-info-sign"></i> ' . __d('acl', 'There was no actions ACOs to prune');
		echo '</div>';
	}
} else {
	echo '<p>';
	echo __d('acl', 'This page allows you to prune obsolete ACOs.');
	echo '</p>';

	echo '<h3>' . __d('acl', 'Obsolete ACO nodes') . '</h3>';
	if (count($nodes_to_prune) > 0) {
		echo '<div class="row">';
		echo '<div class="col-lg-6">';
		echo '<p>';
		echo $this->Html->nestedList($nodes_to_prune);
		echo '</p>';
		echo '</div>';
		echo '<div class="col-lg-6">';
		echo $this->Html->link('<i class="icon-cut"></i> ' . __d('acl', 'Prune'), '/admin/acl/acos/prune_acos/run', array('escape' => false, 'class' => 'btn btn-primary'));
		echo ' ' . __d('acl', 'Clicking the link will not change or remove permissions for actions ACOs that are not obsolete.');
		echo '</div>';
		echo '</div>';
	} else {
		echo '<div class="alert alert-info">';
		echo '<i class="icon-ok"></i> ' . __d('acl', 'There is no ACO node to delete');
		echo '</div>';
	}
}

echo $this->element('design/footer');
?>