# MyStreams for PyroCMS

MyStreams module for PyroCMS makes creating streams and editing entries very easy. Though it does not have GUI for streams administration, it is still smart and helpful tool. Before installing the module, all streams (including relationships) must be set in *config/mystreams.php* file.

- version - 1.2.0
- Author  - Tanel Tammik - keevitaja@gmail.com
- Support - [PyroCMS forum](https://forum.pyrocms.com/discussion/24739/mystreams-module-for-working-with-streams)

#### Screenshots

- [Entries list](https://raw.github.com/keevitaja/mystreams-pyrocms/master/screenshot-entries.png)
- [New entry](https://raw.github.com/keevitaja/mystreams-pyrocms/master/screenshot-new.png)
- [Edit entry](https://raw.github.com/keevitaja/mystreams-pyrocms/master/screenshot-edit.png)

## Basic usage

To set up a simple stream, all you need to do is to edit config file.

*config/mystreams.php*
```php
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['mystreams']['myapp'] = array(
    'people' => array(
        'name' => 'People',
        'fields' => array(
            array(
                'name' => 'Persons name',
                'slug' => 'name',
                'type' => 'text'
            )
        ),
        'update_stream' => array(
            'view_options' => array(
                'id',
                'name'
            )
        )
    )
);
```

This setup will create new stream *people* into the *myapp* namespace. More complex example is provided with this repo. 

> You have to edit the *mystreams.php* before installing the module!

To create/update/delete entries point your browser to admin, content, MyStreams.

In layoyt file you can retrieve entries with:

	{{ mystreams:cycle stream="people" }}
		total: {{ total }}<br>
		{{ entries }}
			{{ name }} <br>
		{{ /entries }}
	{{ /mystreams:cycle }}
	
## Plugin

Please see the [PyroCMS Docs](http://docs.pyrocms.com/2.2/manual/developers/tools/streams-api/entries-driver) for complete list of params.

You can assigne streams to more than one namespace as shown in the example config file *config/mystreams.php* in this repo.

	{{ mystreams:cycle stream="pets" namespace="animals" }}
		total: {{ total }}<br>
		{{ entries }}
			{{ name }} <br>
		{{ /entries }}
	{{ /mystreams:cycle }}

If you are using first namespace in the config file, you do not have to specify it, because it will default to the first namespace.

To see all available tags, use `{{ mystreams:test stream="pets" namespace="animals" }}` which will print out all values with print_r().

## Renaming the module

To rename the module, change following files:

- **change module directory**
- **details.php** - change the class name, in info() method change the name and the description
- **plugin.php** - change the class name, $name and $description
- **config/routes.php** - change the value of $app_name

All these must get same value, except the descriptions.

## The Future

At some point, installing streams will be moved out of the module installation proccess. Then it will be possible to add streams and fields without the need of reinstalling (and loosing all the data) the entire module.




