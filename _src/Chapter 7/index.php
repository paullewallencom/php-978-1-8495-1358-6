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

get('/user/:username', function($app) {
	$app->set('user', User::findByUsername($app->request('username')));
	$app->set('isCurrentUser', ($app->request('username') == User::currentUser() ? true : false));
	$app->render('user/profile');
});

post('/post', function($app) {
	if (User::isAuthenticated()) {
		$post = new Post();
		$post->content = $app->form('content');
		$post->create();
		$app->redirect('/user/' . User::currentUser());
	} else {
		$app->set('error', 'You must be logged in to do that.');
		$app->render('user/login');
	}
});

resolve();