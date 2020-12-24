<?php

use vendor\core\Router;

Router::add('^@(?P<alias>[a-zA-Z0-9-_]+)$',['controller'=>'Profile','action'=>'user']);
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$',['controller'=>'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$',['controller'=>'Page','action'=>'view']);

Router::add('^$',['controller'=>'Main','action'=>'index']);
Router::add('^regist$',['controller'=>'Auth','action'=>'regist']);
Router::add('^login$',['controller'=>'auth','action'=>'login']);
Router::add('^exit$',['controller'=>'auth','action'=>'exit']);
Router::add('^friends$',['controller'=>'Profile','action'=>'friends']);
Router::add('^search$',['controller'=>'Profile','action'=>'foundFriends']);
Router::add('^friends[?=a-zA-Z0-9-]+.$',['controller'=>'Profile','action'=>'friends']);
Router::add('^admin-panel$',['controller'=>'Admin','action'=>'censurePhoto']);
Router::add('^censure$',['controller'=>'Admin','action'=>'censure']);
Router::add('^censure-photo$',['controller'=>'Admin','action'=>'censurePhoto']);
Router::add('^add-admin$',['controller'=>'Admin','action'=>'addAdmin']);
Router::add('^settings$',['controller'=>'Profile','action'=>'edit']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
