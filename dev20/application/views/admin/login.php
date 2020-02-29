<?php
  define('WACKY_LOGIN_PAGES_DIR', base_url('assets/themes/wackylogin/'));
  define('ADMIN_LTE_DIR', base_url('assets/themes/adminlte/'));
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Tutordoors Admin | Login</title>
    
        <link rel="stylesheet" href="<?php echo WACKY_LOGIN_PAGES_DIR;?>/css/style.css">
        <link rel="shortcut icon" href="<?php echo WACKY_LOGIN_PAGES_DIR;?>/img/icon.ico">

  </head>

    <body class="align">

  <div class="site__container">

    <div class="grid__container">

      <form action="" method="post" class="form form--login" id="form-login">

		<!-- <IMG class="displayed" src="<?php echo WACKY_LOGIN_PAGES_DIR;?>/img/wm cms.png" alt="" > -->
        <!-- </IMG> -->
        <img src="<?php echo base_url()?>/assets/images/logo-white.png" alt="logo tutordoors white">
	  
	  
        <div class="form__field">
          <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
          <input id="login__username" type="text" name="email" class="form__input" placeholder="Username" required>
        </div>

        <div class="form__field">
          <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
          <input id="login__password" type="password" name="password" class="form__input" placeholder="Password" required>
        </div>

        <div class="form__field">
          <input type="button" value="Sign In" id="sign-in">
        </div>
        <div id="message" style="color:#fff"></div>
      </form>

    </div>

  </div>


    
  <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <script>
    $('#sign-in').on('click', function() {
      submit_login();
    });
    $('.form__input').keypress(function (e) {
      if (e.which == 13) {
        submit_login();
        return false;    //<---- Add this line
      }
    });

    function submit_login(){
      $.ajax({
        type : "POST",
        url: '<?php echo base_url();?>users/do_login',
        data: $( "#form-login" ).serialize(),
        dataType: "json",
        success:function(data){
          if(data.status == "200")
            window.location.href = "<?php echo base_url('cms/dashboard');?>";
          else if(data.status == "204"){
            $('#message').empty();
            $('#message').append('Username and password not matched.');
          }
          else if(data.status == "205"){
            $('#message').empty();
            $('#message').append('Halaman ini khusus admin.');
          }
        }
      });
    }
  </script>
</body>
</html>
