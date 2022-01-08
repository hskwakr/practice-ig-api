<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$appId = $_ENV['FB_APP_ID'];

?>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script type="module">
import * as api from './js/facebook-api.js';

window.statusChangeCallback = api.statusChangeCallback;
window.switchAuthLink = api.switchAuthLink;
window.checkLoginState = api.checkLoginState;
window.fbLogout = api.fbLogout;

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
  onlogin="checkLoginState()"
>
</fb:login-button>

<form id="ig-form" method="GET" action="">
  <input type="hidden" id="accessToken" name="accessToken" value="">

  <label for="igHashtag">Hashtag name: </label>
  <input type="text" name="igHashtag" value="">

  <button type="submit">Get Posts</button>
</form>
