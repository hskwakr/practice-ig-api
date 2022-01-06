<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$appId = $_ENV['FB_APP_ID'];

?>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script src="js/facebook-api.js"></script>
<script>
window.fbAsyncInit = function() {
  // FB JavaScript SDK configuration and setup
  FB.init({
    appId : '<?php echo $appId; ?>',
    autoLogAppEvents : true,
    xfbml : true,
    version : 'v12.0',
  });

  // Check whether the user already logged in
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
</script>

<a id="fb-logout" href="#" onclick="fbLogout()">Logout</a>
<fb:login-button
  id="fb-login"
  scope="instagram_basic, pages_show_list"
  onlogin="checkLoginState();"
>
</fb:login-button>
