<div class="toolbar-sub">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link('<i class="fa fa-refresh"></i> ' . __d('acl', 'Synchronize actions ACOs'), '/admin/acl/acos/synchronize', array(array('confirm' => __d('acl', 'are you sure ?')), 'class' => 'btn btn-'.(($selected == 'admin_synchronize' ) ? 'primary' : 'default'), 'escape'=>false));
$links[] = $this->Html->link('<i class="fa fa-trash-o"></i> ' . __d('acl', 'Clear actions ACOs'),       '/admin/acl/acos/empty_acos',  array(array('confirm' => __d('acl', 'are you sure ?')), 'class' => 'btn btn-'.(($selected == 'admin_empty_acos' )  ? 'primary' : 'default'), 'escape'=>false));
$links[] = $this->Html->link('<i class="fa fa-plus"></i> ' . __d('acl', 'Build actions ACOs'),       '/admin/acl/acos/build_acl',                                                      array('class' => 'btn btn-'.(($selected == 'admin_build_acl' )   ? 'primary' : 'default'), 'escape'=>false));
$links[] = $this->Html->link('<i class="fa fa-cut"></i> ' . __d('acl', 'Prune actions ACOs'),       '/admin/acl/acos/prune_acos',  array(array('confirm' => __d('acl', 'are you sure ?')), 'class' => 'btn btn-'.(($selected == 'admin_prune_acos' )  ? 'primary' : 'default'), 'escape'=>false));


echo $this->Html->nestedList($links, array('class' => 'list-inline'));
?>
</div>