<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// used in uri, change only if you are renameing the module
$config['mystreams_dir'] = 'mystreams';

// streams data
$config['mystreams'] = array(
    'persons' => array(
        'name' => 'Persons',
        'namespace' => 'family',
        'prefix' => 'family_',
        'fields' => array(
            array(
                'name' => 'First name',
                'slug' => 'persons_first_name',
                'namespace' => 'family',
                'type' => 'text',
                'extra' => array('max_length' => 32),
                'assign' => 'persons',
                'title_column' => true,
                'required' => true,
            ),
            array(
                'name' => 'Last name',
                'slug' => 'persons_last_name',
                'namespace' => 'family',
                'type' => 'text',
                'extra' => array('max_length' => 32),
                'assign' => 'persons'
            ),
            array(
                'name' => 'City',
                'slug' => 'persons_city',
                'namespace' => 'family',
                'type' => 'relationship',
                'extra' => array('choose_stream' => 'locations'), // nested locations stream
                'assign' => 'persons'
            ),
        ),
        'update_stream' => array(
            'view_options' => array(
                'id',
                'persons_first_name',
                'persons_last_name',
                'persons_city'
            )
        )
    ),
    'locations' => array(
        'name' => 'Locations',
        'namespace' => 'family',
        'prefix' => 'family_',
        'fields' => array(
            array(
                'name' => 'City',
                'slug' => 'locations_city',
                'namespace' => 'family',
                'type' => 'text',
                'extra' => array('max_length' => 32),
                'assign' => 'locations',
                'title_column' => true,
                'required' => true,
                'unique' => true
            )
        ),
        'update_stream' => array(
            'view_options' => array(
                'id',
                'locations_city'
            )
        )
    ),
    'pets' => array(
        'name' => 'Pets',
        'namespace' => 'family',
        'prefix' => 'family_',
        'fields' => array(
            array(
                'name' => 'Name',
                'slug' => 'pets_name',
                'namespace' => 'family',
                'type' => 'text',
                'extra' => array('max_length' => 32),
                'assign' => 'pets',
                'title_column' => true,
                'required' => true,
                'unique' => true
            )
        ),
        'update_stream' => array(
            'view_options' => array(
                'id',
                'pets_name'
            )
        )
    )
);