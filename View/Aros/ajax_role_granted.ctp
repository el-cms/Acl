<?php

echo '<span id="right_' . $plugin . '_' . $role_id . '_' . $controller_name . '_' . $action . '">';

if (isset($acl_error)) {
	$title = isset($acl_error_aro) ? __d('acl', 'The role node does not exist in the ARO table') : __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.');
//        echo $this->Html->image('/acl/img/design/important16.png', array('class' => 'pointer', 'alt' => $title, 'title' => $title));
	echo '<i class="fa fa-warning-sign" title="' . $title . '"></i>';
} else {
//        echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer', 'alt' => 'granted'));
	echo '<i class="fa fa-check pointer" title="' . __d('acl', 'Granted') . '"></i>';
}

echo '</span>';
?>