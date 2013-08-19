<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$app_name = 'mystreams';

$route[$app_name . '/admin/(:any)/(:any)/(:any)/(:any)?'] = 'admin/$3/$4';
$route[$app_name . '/admin/(:any)/(:any)/(:any)?'] = 'admin/$3';
$route[$app_name . '/admin/(:any)/(:any)(:any)?'] = 'admin$3';