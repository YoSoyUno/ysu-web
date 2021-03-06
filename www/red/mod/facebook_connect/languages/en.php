<?php
/**
 * An english language definition file
 */

$english = array(
	'facebook_connect' => 'Facebook Services',

	'facebook_connect:requires_oauth' => 'Facebook Services requires the OAuth Libraries plugin to be enabled.',

	'facebook_connect:consumer_key' => 'Facebook Application Id',
	'facebook_connect:consumer_secret' => 'Facebook Application Secret Code',

	'facebook_connect:settings:instructions' => 'You must obtain a client id and secret from <a href="http://www.facebook.com/developers/" target="_blank">Facebook</a>. Most of the fields are self explanatory, the one piece of data you will need is the callback url which takes the form http://[yoursite]/action/facebooklogin/return - [yoursite] is the url of your Elgg network.',

	'facebook_connect:usersettings:description' => "Link your %s account with Facebook.",
	'facebook_connect:usersettings:request' => "You must first <a href=\"%s\">authorize</a> %s to access your Facebook account.",
	'facebook_connect:usersettings:logout_required' => 'You must first authorize %s to access your Facebook account. Request you to kindly logout and login agian.',
	'facebook_connect:authorize:error' => 'Unable to authorize Facebook.',
	'facebook_connect:authorize:success' => 'Facebook access has been authorized.',

	'facebook_connect:usersettings:authorized' => "You have authorized %s to access your Facebook account: @%s.",
	'facebook_connect:usersettings:revoke' => 'Click <a href="%s">here</a> to revoke access.',
	'facebook_connect:revoke:success' => 'Facebook access has been revoked.',

	'facebook_connect:login' => 'Allow existing users who have connected their Facebook account to sign in with Facebook?',
	'facebook_connect:new_users' => 'Allow new users to sign up using their Facebook account even if manual registration is disabled?',
	'facebook_connect:post_onfb' => 'Want to post facebook account synched status on facebook for new users',
	'facebook_connect:post_headder' => 'If you have enabled to post on user wall then configure the following parameter. If you want to use user\'s name or site\'s name then simply use %username% or %sitename% respectively in the text box below. Ex: %username% just synched his/her facebook account with %sitename%',
	'facebook_connect:post_message' => 'Enter Your Message you want to post to user wall <i>(Default: XYZ just synched his/her facebook account with %s)</i>',
	'facebook_connect:post_img' => "Enter the Image url you want to add to the user post <i>(Default: %s_graphics/elgg_logo.png)</i>",
	'facebook_connect:post_descp' => 'Enter the description you want to add to user post <i>(Default: %s is the social network for connecting people.)</i>',
	'facebook_connect:login:success' => 'You have been logged in.',
	'facebook_connect:login:error' => 'Unable to login with Facebook.',
	'facebook_connect:login:button:label' => 'Facebook',
	'facebook_connect:login:button:sublabel' => 'Sign up trought Facebook',

	'facebook_connect:login:email' => "You must enter a valid email address for your new %s account.",


	'facebook_connect:email:subject' => '%s registration successful',
	'facebook_connect:email:body' => '
Hi %s,

Congratulations! You have been successfully registered. Please visit our network here on %s %s.

Your login details are-

Username is %s
Email is %s
Password is %s

You can login using either email id or username.

%s
%s'

	);

add_translation('en', $english);
