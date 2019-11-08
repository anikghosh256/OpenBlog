<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'pages/view';
$route['sitemap\.xml'] = "Sitemap/index";
$route['(?i)post'] = 'posts';
$route['(?i)post/(:any)'] = 'posts/view/$1';
$route['(?i)category'] = 'Posts/category';
$route['(?i)category/(:any)'] = 'Posts/category/$1';
$route['(?i)tag'] = 'Posts/tag';
$route['(?i)tag/(:any)'] = 'Posts/tag/$1';
$route['(?i)author'] = 'Posts/author';
$route['(?i)author/(:any)'] = 'Posts/author/$1';
$route['(?i)search'] = 'Posts/search';
$route['(?i)search/(:any)'] = 'Posts/search/$1';
$route['(?i)posts'] = 'posts';
$route['(?i)posts/(?i)index'] = 'posts/index';
$route['(?i)posts/(:any)'] = 'posts/view/$1';
$route['(?i)login'] = 'user/login';
$route['(?i)register'] = 'user/register';
$route['(?i)logout'] = 'user/logout';
$route['(?i)member'] = 'member/profile';
$route['(?i)admin'] = 'admin/dashboard';

$route['(:any)'] = 'pages/view/$1';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


