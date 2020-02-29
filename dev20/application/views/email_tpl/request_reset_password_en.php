<html>
	<body>
		<p>Hi,</p>
		<p></p>
		<p>You have requested to reset your password, your new password is :<br />
			New Password:   <?php echo $new_password; ?>
			Please visit this link for reseting your password.<br />
		<a href="<?php echo base_url('users/reset?id='.$user_id);?>"><?php echo base_url('users/reset?id='.$user_id);?></a>
		</p>
		<p>Best Regards,<br />
			Tutordoors Team</p>
	</body>
</html>