<?php

echo $this->element('design/header', array('no_acl_links' => true));

echo '<p class="alert alert-warning"><i class="icon-warning-sign"></i> ' . __d('acl', 'Some controllers have been modified, resulting in actions that are not referenced as ACO in the database or ACO records that are obsolete') . '.</p>';

echo '<p>';
echo __d('acl', 'You can update the ACOs by clicking on the following link') . ': ';
echo $this->Html->link('<i class="icon-refresh"></i> ' . __d('acl', 'Synchronize ACOs'), '/admin/acl/acos/synchronize/run', array('class' => 'btn btn-primary', 'escape' => false));
echo '</p>';

echo '<p>';
echo __d('acl', 'Please be aware that this message will appear only once. But you can always rebuild the ACOs by going to the ACO tab.');
echo '</p>';

echo '<div class="row">';
echo '<div class="col-lg-6">';
echo '<h3>' . __d('acl', 'Missing ACOs') . '</h3>';
if (count($missing_aco_nodes) > 0) {
	echo '<p>';
	echo $this->Html->nestedList($missing_aco_nodes);
	echo '</p>';
} else {
	echo '<div class="alert alert-info"><i class="icon-ok"></i> ' . __d('acl', 'There is no missing ACO node.') . '</div>';
}
echo '</div>';
echo '<div class="col-lg-6">';
echo '<h3>' . __d('acl', 'Obsolete ACOs') . '</h3>';
if (count($nodes_to_prune) > 0) {
	echo '<p>';
	echo $this->Html->nestedList($nodes_to_prune);
	echo '</p>';
} else {
	echo '<div class="alert alert-info"><i class="icon-ok"></i> ' . __d('acl', 'There is no obsolete ACO node.') . '</div>';
}
echo '</div>';
echo '</div>';

echo $this->element('design/footer');
?>