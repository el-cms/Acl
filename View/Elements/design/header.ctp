<?php

// Flash messages
echo $this->Session->flash('plugin_acl');

if (!isset($no_acl_links)) {
	$selected = isset($selected) ? $selected : $this->params['controller'];

	$links = array();
	$links[] = $this->Html->link(__d('acl', 'Permissions'), '/admin/acl/aros/index', array('class' => 'btn btn-' . (($selected == 'aros' ) ? 'primary' : 'default')));
	$links[] = $this->Html->link(__d('acl', 'Actions'), '/admin/acl/acos/index', array('class' => 'btn btn-' . (($selected == 'acos' ) ? 'primary' : 'default')));

	echo "<div class=\"toolbar\">\n";
	echo $this->Html->nestedList($links, array('class' => 'list-inline'));
	echo "</div>\n";
}
?>