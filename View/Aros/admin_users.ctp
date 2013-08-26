<?php
echo $this->element('design/header');
?>

<?php
echo $this->element('Aros/links');
?>

<?php
echo $this->Form->create('User', array('url' => array('plugin' => 'acl', 'controller' => 'aros', 'action' => 'admin_users'), 'role' => 'form', 'class' => 'form-inline'));
echo '<div class="form-group">';
echo $this->Form->input($user_display_field, array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => __d('acl', 'User name')));
echo '</div>&nbsp;';
echo $this->Form->end(array('label' => __d('acl', 'Filter'), 'div' => false, 'class' => 'btn btn-default'));
?>
<br/>
<?php
if ($missing_aro) {
	?>
		<p class="alert alert-warning"><i class="icon-warning-sign"></i><?php echo __d('acl', 'Some users AROS are missing. Click on a role to assign one to a user.') ?></p>
	<?php
}
?>

<table class="table table-condensed table-striped">
	<tr>
		<?php
		$column_count = 1;

		$headers = array($this->Paginator->sort($user_display_field, __d('acl', 'name')));

		foreach ($roles as $role) {
			$headers[] = $role[$role_model_name][$role_display_field];
			$column_count++;
		}

		echo $this->Html->tableHeaders($headers);
		?>

	</tr>
	<?php
	foreach ($users as $user) {
		$style = isset($user['Aro']) ? '' : ' class="line_warning"';

		echo '<tr' . $style . '>';
		echo '  <td>' . $user[$user_model_name][$user_display_field] . '</td>';

		foreach ($roles as $role) {
			if (isset($user['Aro']) && $role[$role_model_name][$role_pk_name] == $user[$user_model_name][$role_fk_name]) {
				echo '  <td><i class="icon-ok"></i></td>';
			} else {
				$title = __d('acl', 'Update the user role');
				echo '  <td>' . $this->Html->link('<i class="icon-remove"></i>', '/admin/acl/aros/update_user_role/user:' . $user[$user_model_name][$user_pk_name] . '/role:' . $role[$role_model_name][$role_pk_name], array('title' => $title, 'alt' => $title, 'escape' => false)) . '</td>';
			}
		}

		//echo '  <td>' . (isset($user['Aro']) ? $this->Html->image('/acl/img/design/tick.png') : $this->Html->image('/acl/img/design/cross.png')) . '</td>';

		echo '</tr>';
	}
	?>
	<tr>
		<td colspan="<?php echo $column_count ?>" class="text-center">
			<ul class="pagination">
				<?php
				if ($this->Paginator->hasPrev()):
					echo $this->Paginator->first('<i class="icon-step-backward"></i>', array('tag' => 'li', 'escape' => false));
					echo $this->Paginator->prev('<i class="icon-backward"></i>', array('tag' => 'li', 'escape' => false));
				else:
					?>			<li class="disabled"><span><i class="icon-step-backward"></i></span></li>
					<li class="disabled"><span><i class="icon-backward"></i></span></li>
				<?php
				endif;
				echo $this->Paginator->numbers(array(
					'tag' => 'li',
					'modulus' => '4',
					'separator' => '',
					'currentClass' => 'active',
				));
				if ($this->Paginator->hasNext()):
					echo $this->Paginator->next('<i class="icon-forward"></i>', array('tag' => 'li', 'escape' => false));
					echo $this->Paginator->last('<i class="icon-step-forward"></i>', array('tag' => 'li', 'escape' => false));
				else:
					?>
					<li class="disabled"><span><i class="icon-forward"></i></span></li>
					<li class="disabled"><span><i class="icon-step-forward"></i></span></li>
				<?php endif; ?>	</ul>
			<small class="hidden-sm"><?php echo $this->Paginator->counter('Page {:page}/{:pages}') ?></small>
		</td>
	</tr>
</table>

<?php
echo $this->element('design/footer');
?>