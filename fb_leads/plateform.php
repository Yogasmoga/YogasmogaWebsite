<h3>My Custom Plateform</h3>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '537829066377689',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


// Only works after `FB.init` is called
function myFacebookLogin() {
  FB.login(function(response){
   console.log('Successfully Logged in',response);
		FB.api('/me/accounts',function(response){
			console.log('Successfully pages retrieved',response);
			var pages = response.data;
			var ul = document.getElementById('list');
			for (var i = 0,len = pages.length; i < len; i++)
			{
				var page  =  pages[i];
				var li = createElement('li');
				li.innerHTML = page.name;
				ul.appendChild(li);
			}
		});
  }, {scope: 'manage_pages'});
}
</script>
<button onclick="myFacebookLogin()">Login with Facebook</button>
<ul id="list"></ul>