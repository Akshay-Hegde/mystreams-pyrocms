# MyStreams for PyroCMS

PyroCMS module that makes creating streams and editing entries very easy. It does not want to compete with PyroStreams, but still very useful.

* version - 1.0.0
* Author (Tanel Tammik) (keevitaja@gmail.com)

## Usage

In MyStreams all streams are set up in config file(s) before installing the module. Yes, it does not have GUI to administrate the streams. GUI is only for creating/updating/deleting entries. Never the less setting up a stream is reasonably easy!

To create a simplest stream, edit 2 files in config directory:

mystreams.php

	```<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	// used in uri, change only if you are renaming the module
	$config['mystreams_dir'] = 'mystreams';

	// streams data
	$config['mystreams'] = array(
		'humans' => array(
			'name' => 'Humans',
			'namespace' => 'mystreams',
			'prefix' => 'my_',
			'fields' => array(
				array(
					'name' => 'Full Name',
					'slug' => 'humans_full_name',
					'namespace' => 'mystreams',
					'type' => 'text',
					'assign' => 'humans'
				)
			),
			'update_stream' => array(
				'view_options' => array(
					'id',
					'humans_full_name'
				)
			)
		)
	);
	```

routes.php

	```<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	$route = array();

	$route['mystreams/admin/index'] = 'admin';
	$route['mystreams/admin/humans(:any)?'] = 'admin$1';
	```

This setup will create (after you installed the module) a strem "humans" with a field "humans_full_name". Entries can be added/edited under admin - content - MyStreams. Full setup example is provided with this repo. Please check the config directory.

