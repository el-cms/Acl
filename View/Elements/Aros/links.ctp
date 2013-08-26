<div class="toolbar-sub">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link('<i class="icon-plus"></i> ' . __d('acl', 'Build missing AROs'), '/admin/acl/aros/check', array('class' => 'btn btn-' . (($selected == 'admin_check' )? 'primary' : 'default'), 'escape'=>false));
$links[] = $this->Html->link('<i class="icon-user"></i> ' . __d('acl', 'Users roles'), '/admin/acl/aros/users', array('class' => 'btn btn-' . (($selected == 'admin_users' )? 'primary' : 'default'), 'escape'=>false));

if(Configure :: read('acl.gui.roles_permissions.ajax') === true)
{
    $links[] = $this->Html->link('<i class="icon-group"></i> ' . __d('acl', 'Roles permissions'), '/admin/acl/aros/ajax_role_permissions', array('class' => 'btn btn-' . (($selected == 'admin_role_permissions' || $selected == 'admin_ajax_role_permissions' )? 'primary' : 'default'), 'escape'=>false));
}
else
{
    $links[] = $this->Html->link('<i class="icon-group"></i> ' . __d('acl', 'Roles permissions'), '/admin/acl/aros/role_permissions', array('class' => 'btn btn-' . (($selected == 'admin_role_permissions' || $selected == 'admin_ajax_role_permissions' )? 'primary' : 'default'), 'escape'=>false));
}
$links[] = $this->Html->link('<i class="icon-user"></i> ' . __d('acl', 'Users permissions'), '/admin/acl/aros/user_permissions', array('class' => 'btn btn-' . (($selected == 'admin_user_permissions' )? 'primary' : 'default'), 'escape'=>false));

echo $this->Html->nestedList($links, array('class' => 'list-inline'));
?>
</div>