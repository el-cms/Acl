<?php
echo $this->element('design/header');

echo $this->element('Aros/links');
?>
<?php
if (count($missing_aros['roles']) > 0 || count($missing_aros['users']) > 0) {
	echo '<p>';
	echo $this->Html->link('<i class="icon-plus-sign"></i> ' . __d('acl', 'Build'), '/admin/acl/aros/check/run', array('class' => 'btn btn-primary', 'escape' => false));
	echo '</p>';
} else {
	echo '<div class="alert alert-info">';
	echo '<i class="icon-info-sign"></i> ' . __d('acl', 'There is no missing ARO.');
	echo '</div>';
}
?>
<div class="row">
	<div class="col-lg-6">
		<?php
		if (count($missing_aros['roles']) > 0) {
			echo '<h3>' . __d('acl', 'Roles without corresponding Aro') . '</h3>';

			$list = array();
			foreach ($missing_aros['roles'] as $missing_aro) {
				$list[] = $missing_aro[$role_model_name][$role_display_field];
			}
			echo '<p>';
			echo $this->Html->nestedList($list);
			echo '</p>';
		} else {
			
		}
		?>
	</div>
	<div class="col-lg-6">
		<?php
		if (count($missing_aros['users']) > 0) {
			echo '<h3>' . __d('acl', 'Users without corresponding Aro') . '</h3>';

			$list = array();
			foreach ($missing_aros['users'] as $missing_aro) {
				$list[] = $missing_aro[$user_model_name][$user_display_field];
			}
			echo '<p>';
			echo $this->Html->nestedList($list);
			echo '</p>';
		}
		?>
	</div>
</div>

<?php
echo $this->element('design/footer');
?>