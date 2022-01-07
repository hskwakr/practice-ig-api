/* Facebook login flow
 */

// Set access token to form
function setAccessToken(token) {
}

// Called with the results from FB.getLoginStatus()
export function statusChangeCallback(response) {
  if (response.status === 'connected') {
    switchAuthLink(true);

    setAccessToken(response.authResponse.accessToken);
  } else {
    switchAuthLink(false);
  }
}

// Switch the display of authentication link between login and logout
export function switchAuthLink(isLoggedin) {
  let login = document.getElementById('fb-login');
  let logout = document.getElementById('fb-logout');
  let igForm = document.getElementById('ig-form');

  // During login
  if (isLoggedin) {
    // hide login, show logout
    login.style.display = 'none';
    logout.style.display = 'block';

    igForm.style.display = 'block';
  // During logout
  } else {
    // hide logout, show login
    login.style.display = 'block';
    logout.style.display = 'none';

    igForm.style.display = 'none';
  }
}

// Check whether the user already logged in
export function checkLoginState(response) {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

// Logout from facebook
export function fbLogout() {
  FB.logout(function() {
    switchAuthLink(false);
  });
}
