<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$route = array();

$route['mystreams/admin/index'] = 'admin';
$route['mystreams/admin/persons(:any)?'] = 'admin$1';
$route['mystreams/admin/pets(:any)?'] = 'admin$1';
$route['mystreams/admin/locations(:any)?'] = 'admin$1';