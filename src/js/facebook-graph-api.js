function getFbUserPages() {
  // Get a collection of Facebook Pages 
  FB.api('/me', {fields: 'accounts'}, function(response) {
    // console.log(response.id);
  });
}

// Switch the display of authentication link between login and logout
function switchAuthLink(isLoggedin) {
  if (isLoggedin) { // During login
    // hide login, show logout
    document.getElementById('fb-login').style.display = 'none';
    document.getElementById('fb-logout').style.display = 'block';
  } else {          // During logout
    // hide logout, show login
    document.getElementById('fb-login').style.display = 'block';
    document.getElementById('fb-logout').style.display = 'none';
  }
}

// Called with the results from FB.getLoginStatus()
function statusChangeCallback(response) {
  if (response.status === 'connected') {
    switchAuthLink(true);
    getFbUserPages();
  } else {
    switchAuthLink(false);
  }
}

// Check whether the user already logged in
function checkLoginState(response) {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

// Logout from facebook
function fbLogout() {
  FB.logout(function() {
    switchAuthLink(false);
  });
}
