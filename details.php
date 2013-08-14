<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Mystreams extends Module
{
    public $version = '1.0';

    public function __construct()
    {
        parent::__construct();

        $this->config->load('mystreams/mystreams');
    }

    public function _sections()
    {
        $streams = $this->config->item('mystreams');
        $dir = $this->config->item('mystreams_dir');

        $sections = array();

        foreach ($streams as $stream => $data)
        {
            $sections[$stream] = array(
                'name' => $data['name'],
                'uri' => 'admin/' . $dir . '/' . $stream,
                'shortcuts' => array(
                    'create' => array(
                        'name' => 'global:add',
                        'uri' => 'admin/' . $dir . '/' . $stream . '/create',
                        'class' => 'add'
                    )
                )
            );
        }

        return $sections;
    }

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'MyStreams'
            ),
            'description' => array(
                'en' => 'Small module for streams'
            ),
            'backend' => true,
            'menu' => 'content',
            'sections' => $this->_sections()
        );
    }

    public function install()
    {
        $this->load->driver('Streams');

        $streams = $this->config->item('mystreams');

        // remove streams
        foreach ($streams as $data)
        {
            $this->streams->utilities->remove_namespace($data['namespace']);
        }

        $created_streams = array();

        // add streams
        foreach ($streams as $stream => $data)
        {
            $created_streams[$stream] = $this->streams->streams->add_stream($data['name'], $stream, $data['namespace'], $data['prefix'], null);

            if ( ! $created_streams[$stream])
            {
                return false;
            }
        }

        // update relationships
        foreach ($streams as $stream => $data)
        {
            foreach ($data['fields'] as $key => $field)
            {
                if ($field['type'] == 'relationship')
                {
                    if (isset($created_streams[$field['extra']['choose_stream']]))
                    {
                        $streams[$stream]['fields'][$key]['extra']['choose_stream'] = $created_streams[$field['extra']['choose_stream']];
                    }
                }
            }
        }

        // add fields
        foreach ($streams as $stream => $data)
        {
            $this->streams->fields->add_fields($data['fields']);

            if (isset($data['update_stream']))
            {
                $this->streams->streams->update_stream($stream, $data['namespace'], $data['update_stream']);
            }
        }

        return true;
    }

    public function uninstall()
    {
        $this->load->driver('Streams');

        $streams = $this->config->item('mystreams');

        foreach ($streams as $data)
        {
            $this->streams->utilities->remove_namespace($data['namespace']);
        }

        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }
}