import { FacebookGraphApi } from './facebook-graph-api.js';

let graphApi = new FacebookGraphApi(); 

export function getId() {
  // Get a collection of Facebook Pages 
  FB.api('/me', {fields: 'accounts'}, function(response) {
    // console.log(response.id);
  });
}

// Called with the results from FB.getLoginStatus()
export function statusChangeCallback(response) {
  if (response.status === 'connected') {
    switchAuthLink(true);

    // Run our script
  } else {
    switchAuthLink(false);
  }
}

// Switch the display of authentication link between login and logout
export function switchAuthLink(isLoggedin) {
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
