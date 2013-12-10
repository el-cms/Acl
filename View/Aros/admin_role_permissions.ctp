<?php
echo $this->Html->script('/acl/js/jquery');
echo $this->Html->script('/acl/js/acl_plugin');

echo $this->element('design/header');
?>

<?php
echo $this->element('Aros/links');
?>

<div>

	<?php
	echo $this->Html->link('<i class="fa fa-trash-o"></i> ' . __d('acl', 'Clear permissions table'), '/admin/acl/aros/empty_permissions', array('confirm' => __d('acl', 'Are you sure you want to delete all roles and users permissions ?'), 'escape' => false, 'class' => 'btn btn-danger'));
	?>


</div>
<h3><?php echo __d('acl', 'Mass permissions') ?></h3>
<div class="text-warning">
	<?php echo __d('acl', 'Be careful, mass permissions will overwrite custom ones.') ?>
</div>
<table class="table table-condensed table-striped">

	<tr>
		<th></th>
		<th class="text-center"><?php echo __d('acl', 'grant access to <em>all actions</em>'); ?></th>
		<th class="text-center"><?php echo __d('acl', 'deny access to <em>all actions</em>'); ?></th>
	</tr>

	<?php
//$i = 0;
	foreach ($roles as $role) {
//    $color = ($i % 2 == 0) ? 'color1' : 'color2';
		echo '<tr>';
		echo '  <td>' . $role[$role_model_name][$role_display_field] . '</td>';
		echo '  <td class="text-center">' . $this->Html->link('<i class="fa fa-check"></i>', '/admin/acl/aros/grant_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'class' => 'btn btn-link', 'confirm' => sprintf(__d('acl', "Are you sure you want to grant access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
		echo '  <td class="text-center">' . $this->Html->link('<i class="fa fa-times"></i>', '/admin/acl/aros/deny_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'class' => 'btn btn-link', 'confirm' => sprintf(__d('acl', "Are you sure you want to deny access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
		echo '<tr>';

//    $i++;
	}
	?>
</table>

<h3><?php echo __d('acl', 'Specific permissions') ?></h3>
<p>
	<em><?php echo __d('acl', 'Legend:'); ?></em> <i class="fa fa-check"></i> = <?php echo __d('acl', 'Permission granted') ?> - <i class="fa fa-times"></i> = <?php echo __d('acl', 'Permission denied') ?>
</p>

<table class="table table-condensed table-striped">
	<tr>
		<?php
		$column_count = 1;

		$headers = array(__d('acl', 'Action'));

		foreach ($roles as $role) {
			$headers[] = $role[$role_model_name][$role_display_field];
			$column_count++;
		}

		echo $this->Html->tableHeaders($headers);
		?>
	</tr>

	<?php
	if (isset($actions['app']) && is_array($actions['app'])) {
		foreach ($actions['app'] as $controller_name => $ctrl_infos) {
//			if($previous_ctrl_name != $controller_name)
//			{
//				$previous_ctrl_name = $controller_name;
//				
//			}

			foreach ($ctrl_infos as $ctrl_info) {
				echo '<tr>';

				echo '<td>' . $controller_name . '->' . $ctrl_info['name'] . '</td>';

				foreach ($roles as $role) {
					echo '<td>';
					echo '<span id="right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '">';

					if (isset($ctrl_info['permissions'][$role[$role_model_name][$role_pk_name]])) {
						if ($ctrl_info['permissions'][$role[$role_model_name][$role_pk_name]] == 1) {
							$this->Js->buffer('register_role_toggle_right(true, "' . $this->Html->url('/') . '", "right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');

//							echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer'));
							echo '<i class="fa fa-check pointer"></i>';
						} else {
							$this->Js->buffer('register_role_toggle_right(false, "' . $this->Html->url('/') . '", "right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');

//							echo $this->Html->image('/acl/img/design/cross.png', array('class' => 'pointer'));
							echo '<i class="fa fa-times pointer"></i>';
						}
					} else {
						/*
						 * The right of the action for the role is unknown
						 */
//						echo $this->Html->image('/acl/img/design/important16.png', array('title' => __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.')));
						echo '<i class="fa fa-warning-sign" title="' . __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.') . '"></i>';
					}

					echo '</span>';

					echo ' ';
//        	    	echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner', 'style' => 'display:none;'));
					echo '<i class="fa fa-spinner fa fa-spin" title="' . __d('acl', 'Loading...') . '" id="' . 'right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner' . '" style="display:none"></i>';

					echo '</td>';
				}

				echo '</tr>
		    	';
			}

//				$i++;
		}
	}
	?>
	<?php
	if (isset($actions['plugin']) && is_array($actions['plugin'])) {
		foreach ($actions['plugin'] as $plugin_name => $plugin_ctrler_infos) {
//    	    debug($plugin_name);
//    	    debug($plugin_ctrler_infos);

			$color = null;

			echo '<tr><th colspan="' . $column_count . '">' . __d('acl', 'Plugin') . ' ' . $plugin_name . '</th></tr>';

//			$i = 0;
			foreach ($plugin_ctrler_infos as $plugin_ctrler_name => $plugin_methods) {
				//debug($plugin_ctrler_name);
				//echo '<tr style="background-color:#888888;color:#ffffff;"><td colspan="' . $column_count . '">' . $plugin_ctrler_name . '</td></tr>';
//        	    if($previous_ctrl_name != $plugin_ctrler_name)
//        		{
//        			$previous_ctrl_name = $plugin_ctrler_name;
//        			
//        			$color = ($i % 2 == 0) ? 'color1' : 'color2';
//        		}


				foreach ($plugin_methods as $method) {
					echo '<tr>
    	            ';

					echo '<td>' . $plugin_ctrler_name . '->' . $method['name'] . '</td>';
					//debug($method['name']);

					foreach ($roles as $role) {
						echo '<td>';
						echo '<span id="right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '">';

						if (isset($ctrl_info['permissions'][$role[$role_model_name][$role_pk_name]])) {
							if ($method['permissions'][$role[$role_model_name][$role_pk_name]] == 1) {
								//echo '<td>' . $this->Html->link($this->Html->image('/acl/img/design/tick.png'), '/admin/acl/aros/deny_role_permission/' . $role[$role_model_name][$role_pk_name] . '/plugin:' . $plugin_name . '/controller:' . $plugin_ctrler_name . '/action:' . $method['name'], array('escape' => false)) . '</td>';

								$this->Js->buffer('register_role_toggle_right(true, "' . $this->Html->url('/') . '", "right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . $method['name'] . '")');

//								echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer'));
								echo '<i class="fa fa-check pointer"></i>';
							} else {
								//echo '<td>' . $this->Html->link($this->Html->image('/acl/img/design/cross.png'), '/admin/acl/aros/grant_role_permission/' . $role[$role_model_name][$role_pk_name] . '/plugin:' . $plugin_name .'/controller:' . $plugin_ctrler_name . '/action:' . $method['name'], array('escape' => false)) . '</td>';

								$this->Js->buffer('register_role_toggle_right(false, "' . $this->Html->url('/') . '", "right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . $method['name'] . '")');

//								echo $this->Html->image('/acl/img/design/cross.png', array('class' => 'pointer'));
								echo '<i class="fa fa-times pointer"></i>';
							}
						} else {
							/*
							 * The right of the action for the role is unknown
							 */
//							echo $this->Html->image('/acl/img/design/important16.png', array('title' => __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.')));
							echo '<i class="fa fa-warning-sign" title="' . __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.') . '"></i>';
						}

						echo '</span>';

						echo ' ';
//            	    	echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '_spinner', 'style' => 'display:none;'));
						echo '<i class="fa fa-spinner fa fa-spin" title="' . __d('acl', 'Loading...') . '" id="' . 'right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '_spinner' . '" style="display:none"></i>';

						echo '</td>';
					}

					echo '</tr>';
				}

//				$i++;
			}
		}
	}
	?>
</table>
<?php
echo $this->element('design/footer');
?>