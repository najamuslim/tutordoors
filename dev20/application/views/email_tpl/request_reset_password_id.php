<html>
	<body>
		<p>Hai,</p>
		<p></p>
		<p>Anda telah meminta untuk reset password, password baru anda adalah:<br />
			Password Baru:   <?php echo $new_password; ?>
			Anda telah meminta untuk reset password, silahkan klik link berikut:<br />
		<a href="<?php echo base_url('users/reset?id='.$user_id);?>"><?php echo base_url('users/reset?id='.$user_id);?></a>
		</p>
		<p>Salam,<br />
			Admin Tutordoors</p>
	</body>
</html>