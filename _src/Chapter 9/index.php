<?php
include 'lib/bones.php';

define('ADMIN_USER', 'tim');
define('ADMIN_PASSWORD', 'test');

get('/', function($app) {
	$app->set('message', 'Welcome Back!');
	$app->render('home');
});

get('/signup', function($app) {
	$app->render('user/signup');
});

post('/signup', function($app) {
	$user = new User();
	$user->full_name = $app->form('full_name');
	$user->email = $app->form('email');
	$user->signup($app->form('username'), $app->form('password'));
	
	$app->set('success', 'Thanks for Signing Up ' . $user->full_name . '!');
	$app->render('home');
});

get('/login', function($app) {
	$app->render('user/login');
});

post('/login', function($app) {
	$user = new User();
	$user->name = $app->form('username');
	$user->login($app->form('password'));
	
	$app->set('success', 'You are now logged in!');
	$app->render('home');
});

get('/logout', function($app) {
  User::logout();
  $app->redirect('/');
});

function get_user_profile($app) {
  $app->set('user', User::get_by_username($app->request('username')));
	$app->set('is_current_user', ($app->request('username') == User::current_user() ? true : false));
	$app->set('posts', Post::get_posts_by_user($app->request('username'), ($app->request('skip') ? $app->request('skip') : 0)));
	$app->set('post_count', Post::get_post_count_by_user($app->request('username')));
}

get('/user/:username', function($app) {
  get_user_profile($app);
  $app->render('user/profile');
});

get('/user/:username/:skip', function($app) {
  get_user_profile($app);
  $app->render('user/_posts', false);
});


post('/post', function($app) {
	if (User::is_authenticated()) {
		$post = new Post();
		$post->content = $app->form('content');
		$post->create();
		$app->redirect('/user/' . User::current_user());
	} else {
		$app->set('error', 'You must be logged in to do that.');
		$app->render('user/login');
	}
});

delete('/post/delete/:id/:rev', function($app) {
	$post = new Post();
	$post->_id = $app->request('id');
	$post->_rev = $app->request('rev');
	$post->delete();
	
	$app->set('success', 'Your post has been deleted');
	$app->redirect('/user/' . User::current_user());
});

resolve();