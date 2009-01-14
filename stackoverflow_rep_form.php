<?php
$options = get_option("stackoverflow_rep_options");
if (!is_array( $options)){
  $options = array(
		   'stackoverflow_rep_title' => 'StackOverflow.com Reputation',
		   'stackoverflow_rep_username' => '',
		   'stackoverflow_rep_id' => ''
		   );	
}
?>
<p>Widget title:<br/>
<input type='text' name='stackoverflow_rep_title' value="<?php echo $options['stackoverflow_rep_title']  ?>"/></p>
<p>StackOverflow user:<br/>
<input type='text' name='stackoverflow_rep_username' value="<?php echo $options['stackoverflow_rep_username']  ?>" /></p>
<p>User ID<br/>
<input type='text' name='stackoverflow_rep_id' value="<?php echo $options['stackoverflow_rep_id']  ?>" /></p>

<?php
if ($_POST['stackoverflow_rep_submit']){
	
	$options['stackoverflow_rep_title']=htmlspecialchars($_POST['stackoverflow_rep_title']);
	$options['stackoverflow_rep_username']=htmlspecialchars($_POST['stackoverflow_rep_username']);
	$options['stackoverflow_rep_id']=htmlspecialchars($_POST['stackoverflow_rep_id']);

	update_option("stackoverflow_rep_title", $options['stackoverflow_rep_title']);
	update_option("stackoverflow_rep_username", $options['stackoverflow_rep_username']);
	update_option("stackoverflow_rep_id", $options['stackoverflow_rep_id']);
}
?>
	<input type="hidden" id="stackoverflow_rep_submit" name="stackoverflow_rep_submit" value="1" />
