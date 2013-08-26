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
	echo $this->Html->link('<i class="icon-trash"></i> ' . __d('acl', 'Clear permissions table'), '/admin/acl/aros/empty_permissions', array('confirm' => __d('acl', 'Are you sure you want to delete all roles and users permissions ?'), 'escape' => false, 'class' => 'btn btn-danger'));
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
		echo '  <td class="text-center">' . $this->Html->link('<i class="icon-ok"></i>', '/admin/acl/aros/grant_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'class' => 'btn btn-link', 'confirm' => sprintf(__d('acl', "Are you sure you want to grant access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
		echo '  <td class="text-center">' . $this->Html->link('<i class="icon-remove"></i>', '/admin/acl/aros/deny_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'class' => 'btn btn-link', 'confirm' => sprintf(__d('acl', "Are you sure you want to deny access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
		echo '<tr>';

//    $i++;
	}
	?>
</table>

<h3><?php echo __d('acl', 'Specific permissions') ?></h3>
<p>
	<em><?php echo __d('acl', 'Legend:'); ?></em> <i class="icon-ok"></i> = <?php echo __d('acl', 'Permission granted') ?> - <i class="icon-remove"></i> = <?php echo __d('acl', 'Permission denied') ?>
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
	$js_init_done = array();
//	$previous_ctrl_name = '';
	$i = 0;

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

					/*
					 * The right of the action for the role must still be loaded
					 */
//    		        echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('title' => __d('acl', 'loading')));
					echo '<i class="icon-spinner icon-spin" title="' . __d('acl', 'Loading...') . '"></i>';

					if (!in_array($controller_name . '_' . $role[$role_model_name][$role_pk_name], $js_init_done)) {
						$js_init_done[] = $controller_name . '_' . $role[$role_model_name][$role_pk_name];
						$this->Js->buffer('init_register_role_controller_toggle_right("' . $this->Html->url('/', true) . '", "' . $role[$role_model_name][$role_pk_name] . '", "", "' . $controller_name . '", "' . __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.') . '");');
					}

					echo '</span>';

					echo ' ';
//        	    	echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner', 'style' => 'display:none;'));
					echo '<i class="icon-spinner icon-spin" title="' . __d('acl', 'Loading...') . '" id="' . 'right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner' . '" style="display:none"></i>';

					echo '</td>';
				}

				echo '</tr>
		    	';
			}

			$i++;
		}
	}
	if (isset($actions['plugin']) && is_array($actions['plugin'])) {
		foreach ($actions['plugin'] as $plugin_name => $plugin_ctrler_infos) {
//    	    debug($plugin_name);
//    	    debug($plugin_ctrler_infos);

			$color = null;

			echo '<tr><th colspan="' . $column_count . '">' . __d('acl', 'Plugin') . ' ' . $plugin_name . '</th></tr>';

			$i = 0;
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
					echo '<tr class="' . $color . '">
    	            ';

					echo '<td>' . $plugin_ctrler_name . '->' . $method['name'] . '</td>';
					//debug($method['name']);

					foreach ($roles as $role) {
						echo '<td>';
						echo '<span id="right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '">';

						/*
						 * The right of the action for the role must still be loaded
						 */
//    		    	    echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('title' => __d('acl', 'loading')));
						echo '<i class="icon-spinner icon-spin" title="' . __d('acl', 'Loading...') . '"></i>';

						if (!in_array($plugin_name . "_" . $plugin_ctrler_name . '_' . $role[$role_model_name][$role_pk_name], $js_init_done)) {
							$js_init_done[] = $plugin_name . "_" . $plugin_ctrler_name . '_' . $role[$role_model_name][$role_pk_name];
							$this->Js->buffer('init_register_role_controller_toggle_right("' . $this->Html->url('/', true) . '", "' . $role[$role_model_name][$role_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.') . '");');
						}

						echo '</span>';

						echo ' ';
//            	    	echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '_spinner', 'style' => 'display:none;'));
						echo '<i class="icon-spinner icon-spin" title="' . __d('acl', 'Loading...') . '" id="' . 'right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '_spinner' . '" style="display:none"></i>';
						echo '</td>';
					}

					echo '</tr>
    	            ';
				}

				$i++;
			}
		}
	}
	?>
</table>

<?php
echo $this->element('design/footer');
?>