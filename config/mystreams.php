<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// family is the namespace
// persons is the stream

$config['mystreams']['family'] = array(
    'persons' => array(
        'name' => 'Persons',
        'fields' => array(
            array(
                'name' => 'First name',
                'slug' => 'first_name',
                'type' => 'text',
                'extra' => array('max_length' => 32),
                'title_column' => true,
                'required' => true,
            ),
            array(
                'name' => 'Last name',
                'slug' => 'last_name',
                'type' => 'text',
                'extra' => array('max_length' => 32),
            ),
            array(
                'name' => 'City',
                'slug' => 'city_name',
                'type' => 'relationship',
                'extra' => array('choose_stream' => 'locations'), // nested locations stream
            ),
        ),
        'update_stream' => array(
            'view_options' => array(
                'id',
                'first_name',
                'last_name',
                'city_name'
            )
        )
    ),
    'locations' => array(
        'name' => 'Locations',
        'fields' => array(
            array(
                'name' => 'City name',
                'slug' => 'name',
                'type' => 'text',
                'extra' => array('max_length' => 32),
                'title_column' => true,
                'required' => true,
                'unique' => true
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

$config['mystreams']['animals'] = array(
    'pets' => array(
        'name' => 'Pets',
        'fields' => array(
            array(
                'name' => 'Pet name',
                'slug' => 'name',
                'type' => 'text',
                'extra' => array('max_length' => 32),
                'title_column' => true,
                'required' => true,
                'unique' => true
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