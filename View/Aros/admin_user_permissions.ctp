<?php
echo $this->Html->script('/acl/js/jquery');
echo $this->Html->script('/acl/js/acl_plugin');

echo $this->element('design/header');
echo $this->element('Aros/links');


if (isset($users)) {
	?>
	<?php
	echo '<p>';
	echo __d('acl', 'This page allows to manage users specific rights');
	echo '</p>';

	echo $this->Form->create('User', array('role' => 'form', 'class' => 'form-inline'));
	echo '<div class="form-group">';
	echo $this->Form->input($user_display_field, array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => __d('acl', 'User name')));
	echo '</div>&nbsp;';
	echo $this->Form->end(array('label' => __d('acl', 'filter'), 'div' => false, 'class' => 'btn btn-default'));
	echo '<br/>';
	?>
	<table class="table table-condensed table-striped">
		<tr>
			<?php
			$column_count = 2;

			$headers = array($this->Paginator->sort(__d('acl', 'user'), $user_display_field), null);

			echo $this->Html->tableHeaders($headers);
			?>
		</tr>
		<?php
		foreach ($users as $user) {
			echo '<tr>';
			echo '  <td>' . $user[$user_model_name][$user_display_field] . '</td>';
			$title = __d('acl', 'Manage user specific rights');

			$link = '/admin/acl/aros/user_permissions/' . $user[$user_model_name][$user_pk_name];
			if (Configure :: read('acl.gui.users_permissions.ajax') === true) {
				$link .= '/ajax:true';
			}

			echo '  <td>' . $this->Html->link('<i class="fa fa-lock"></i>', $link, array('alt' => $title, 'title' => $title, 'escape' => false)) . '</td>';

			echo '</tr>';
		}
		?>
		<td colspan="<?php echo $column_count ?>" class="text-center">
			<ul class="pagination">
				<?php
				if ($this->Paginator->hasPrev()):
					echo $this->Paginator->first('<i class="fa fa-step-backward"></i>', array('tag' => 'li', 'escape' => false));
					echo $this->Paginator->prev('<i class="fa fa-backward"></i>', array('tag' => 'li', 'escape' => false));
				else:
					?>			<li class="disabled"><span><i class="fa fa-step-backward"></i></span></li>
					<li class="disabled"><span><i class="fa fa-backward"></i></span></li>
				<?php
				endif;
				echo $this->Paginator->numbers(array(
					'tag' => 'li',
					'modulus' => '4',
					'separator' => '',
					'currentClass' => 'active',
				));
				if ($this->Paginator->hasNext()):
					echo $this->Paginator->next('<i class="fa fa-forward"></i>', array('tag' => 'li', 'escape' => false));
					echo $this->Paginator->last('<i class="fa fa-step-forward"></i>', array('tag' => 'li', 'escape' => false));
				else:
					?>
					<li class="disabled"><span><i class="fa fa-forward"></i></span></li>
					<li class="disabled"><span><i class="fa fa-step-forward"></i></span></li>
				<?php endif; ?>	</ul>
			<small class="hidden-sm"><?php echo $this->Paginator->counter('Page {:page}/{:pages}') ?></small>
		</td>
	</table>
	<?php
} else {
	?>
	<h2><?php echo __d('acl', $user_model_name) . ' : ' . $user[$user_model_name][$user_display_field]; ?></h2>

	<h3><?php echo __d('acl', 'Role'); ?></h3>

	<table class="table table-condensed table-striped">
		<tr>
			<?php
			foreach ($roles as $role) {
				echo '<td>';

				echo $role[$role_model_name][$role_display_field] . ' ';
				if ($role[$role_model_name][$role_pk_name] == $user[$user_model_name][$role_fk_name]) {
//					echo $this->Html->image('/acl/img/design/tick.png');
					echo '<i class="fa fa-check text-success"></i>';
				} else {
					$title = __d('acl', 'Update the user role');
//					echo $this->Html->link($this->Html->image('/acl/img/design/tick_disabled.png'), array('plugin' => 'acl', 'controller' => 'aros', 'action' => 'update_user_role', 'user' => $user[$user_model_name][$user_pk_name], 'role' => $role[$role_model_name][$role_pk_name]), array('title' => $title, 'alt' => $title, 'escape' => false));
					echo $this->Html->link('<i class="fa fa-check"></i>', array('plugin' => 'acl', 'controller' => 'aros', 'action' => 'update_user_role', 'user' => $user[$user_model_name][$user_pk_name], 'role' => $role[$role_model_name][$role_pk_name]), array('title' => $title, 'alt' => $title, 'escape' => false));
				}

				echo '</td>';
			}
			?>
		</tr>
	</table>

	<h3><?php echo __d('acl', 'Permissions'); ?></h3>

	<?php
	if ($user_has_specific_permissions) {
		echo '<div class="alert alert-info">';
		echo '<span class="fa fa-stack">
				<i class="fa fa-circle fa fa-stack-base"></i>
				<i class="fa fa-lightbulb fa fa-light"></i>
			</span> ' . __d('acl', 'This user has specific permissions.');
		echo ' ' . $this->Html->link('<i class="fa fa-times"></i> ' . __d('acl', 'Reset to role permissions'), '/admin/acl/aros/clear_user_specific_permissions/' . $user[$user_model_name][$user_pk_name], array('confirm' => __d('acl', 'Are you sure you want to clear the permissions specific to this user ?'), 'escape' => false, 'class' => 'btn btn-xs btn-primary'));
		echo '</div>';
	}
	?>

	<table class="table table-condensed table-striped">
		<tr>
			<?php
			$column_count = 1;

			$headers = array(__d('acl', 'Action'), __d('acl', 'Authorization'));

			echo $this->Html->tableHeaders($headers);
			?>
		</tr>

		<?php
		$previous_ctrl_name = '';

		//debug($actions);
		if (isset($actions['app']) && is_array($actions['app'])) {
			foreach ($actions['app'] as $controller_name => $ctrl_infos) {
//				if ($previous_ctrl_name != $controller_name) {
//					$previous_ctrl_name = $controller_name;
//
//					$color = (isset($color) && $color == 'color1') ? 'color2' : 'color1';
//				}

				foreach ($ctrl_infos as $ctrl_info) {
					//debug($ctrl_info);

					echo '<tr>';

					echo '<td>' . $controller_name . '->' . $ctrl_info['name'] . '</td>';

					echo '<td>';
					echo '<span id="right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '">';

					if ($ctrl_info['permissions'][$user[$user_model_name][$user_pk_name]] == 1) {
						$this->Js->buffer('register_user_toggle_right(true, "' . $this->Html->url('/') . '", "right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $user[$user_model_name][$user_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');

//						echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer'));
						echo '<i class="fa fa-check pointer"></i>';
					} elseif ($ctrl_info['permissions'][$user[$user_model_name][$user_pk_name]] == 0) {
						$this->Js->buffer('register_user_toggle_right(false, "' . $this->Html->url('/') . '", "right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $user[$user_model_name][$user_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');

//						echo $this->Html->image('/acl/img/design/cross.png', array('class' => 'pointer'));
						echo '<i class="fa fa-times pointer"></i>';
					} elseif ($ctrl_info['permissions'][$user[$user_model_name][$user_pk_name]] == -1) {
//						echo $this->Html->image('/acl/img/design/important16.png');
						echo '<i class="fa fa-warning-sign"></i>';
					}

					echo '</span>';

					echo ' ';
//					echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner', 'style' => 'display:none;'));
					echo '<i class="fa fa-spinner fa fa-spin" id="' . 'right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner' . '" style="display:none" title="' . __d('acl', 'Loading...') . '"></i>';
					echo '</td>';
					echo '</tr>
    	    	';
				}
			}
		}
		?>
		<?php
		if (isset($actions['plugin']) && is_array($actions['plugin'])) {
			foreach ($actions['plugin'] as $plugin_name => $plugin_ctrler_infos) {
				echo '<tr><th colspan="2">' . __d('acl', 'Plugin') . ' ' . $plugin_name . '</th></tr>
    	    ';

				foreach ($plugin_ctrler_infos as $plugin_ctrler_name => $plugin_methods) {
					if ($previous_ctrl_name != $plugin_ctrler_name) {
						$previous_ctrl_name = $plugin_ctrler_name;

						$color = (isset($color) && $color == 'color1') ? 'color2' : 'color1';
					}

					foreach ($plugin_methods as $method) {
						echo '<tr class="' . $color . '">
    	            ';

						echo '<td>' . $plugin_ctrler_name . '->' . $method['name'] . '</td>';
						//debug($method['name']);

						echo '<td>';
						echo '<span id="right_' . $plugin_name . '_' . $user[$user_model_name][$user_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '">';

						if ($method['permissions'][$user[$user_model_name][$user_pk_name]] == 1) {
							$this->Js->buffer('register_user_toggle_right(true, "' . $this->Html->url('/') . '", "right_' . $plugin_name . '_' . $user[$user_model_name][$user_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '", "' . $user[$user_model_name][$user_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . $method['name'] . '")');

//							echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer'));
							echo '<i class="fa fa-check pointer"></i>';
						} elseif ($method['permissions'][$user[$user_model_name][$user_pk_name]] == 0) {
							$this->Js->buffer('register_user_toggle_right(false, "' . $this->Html->url('/') . '", "right_' . $plugin_name . '_' . $user[$user_model_name][$user_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '", "' . $user[$user_model_name][$user_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . $method['name'] . '")');

//							echo $this->Html->image('/acl/img/design/cross.png', array('class' => 'pointer'));
							echo '<i class="fa fa-times pointer"></i>';
						} elseif ($method['permissions'][$user[$user_model_name][$user_pk_name]] == -1) {
//							echo $this->Html->image('/acl/img/design/important16.png');
							echo '<i class="fa fa-warning-sign"></i>';
						} else {
							echo '?';
						}

						echo '</span>';

						echo ' ';
//						echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right_' . $plugin_name . '_' . $user[$user_model_name][$user_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '_spinner', 'style' => 'display:none;'));
						echo '<i class="fa fa-spinner fa fa-spin" id="' . 'right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner' . '" style="display:none" title="' . __d('acl', 'Loading...') . '"></i>';

						echo '</td>';
						echo '</tr>
    	            ';
					}
				}
			}
		}
		?>
	</table>
	<?php
	echo $this->Html->image('/acl/img/design/tick.png') . ' ' . __d('acl', 'authorized');
	echo '&nbsp;&nbsp;&nbsp;';
	echo $this->Html->image('/acl/img/design/cross.png') . ' ' . __d('acl', 'blocked');
	?>
	<?php
}
?>
<?php
echo $this->element('design/footer');
?>