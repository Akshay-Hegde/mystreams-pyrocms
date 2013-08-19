<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Mystreams extends Module
{
    public $version = '1.2.0';

    private $module_name;

    private $streams_data;

    public function __construct()
    {
        parent::__construct();

        $this->module_name = strtolower(str_replace('Module_', '', get_class()));

        $this->load->driver('Streams');

        $this->config->load($this->module_name . '/mystreams');

        $this->streams_data = $this->config->item('mystreams');
    }

    // formats section data for admin menu
    private function _sections()
    {
        $sections = array();

        foreach ($this->streams_data as $namespace => $stream)
        {
            foreach ($stream as $stream_slug => $stream_data)
            {
                $uri = implode('/', array('admin', $this->module_name, $namespace, $stream_slug));

                $sections[$stream_slug] = array(
                    'name' => $stream_data['name'],
                    'uri' => $uri,
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'global:add',
                            'uri' => $uri . '/create',
                            'class' => 'add'
                        )
                    )
                );
            }
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

    private function uninstall_streams()
    {
        foreach (array_keys($this->streams_data) as $namespace)
        {
            $this->streams->utilities->remove_namespace($namespace);
        }
    }

    public function install()
    {
        $this->uninstall_streams();

        // install streams
        $installed_streams = array();

        foreach ($this->streams_data as $namespace => $stream)
        {
            foreach ($stream as $stream_slug => $stream_data)
            {
                $installed_streams[$stream_slug] = $this->streams->streams->add_stream(
                    $stream_data['name'],
                    $stream_slug,
                    $namespace,
                    $namespace . '_',
                    null
                );
            }
        }

        // install fields
        $fields = array();

        foreach ($this->streams_data as $namespace => $stream)
        {
            foreach ($stream as $stream_slug => $stream_data)
            {
                foreach ($stream_data['fields'] as $field)
                {
                    $field['slug'] = $namespace . '_' . $stream_slug . '_' . $field['slug'];
                    $field['namespace'] = $namespace;
                    $field['assign'] = $stream_slug;

                    if ($field['type'] == 'relationship')
                    {
                        $field['extra']['choose_stream'] = $installed_streams[$field['extra']['choose_stream']];
                    }

                    $fields[] = $field;
                }
            }
        }

        $this->streams->fields->add_fields($fields);

        // add view options
        foreach ($this->streams_data as $namespace => $stream)
        {
            foreach ($stream as $stream_slug => $stream_data)
            {
                $fields_slugs = array();

                foreach ($stream_data['fields'] as $field)
                {
                    $fields_slugs[] = $field['slug'];
                }

                $update = $stream_data['update_stream']['view_options'];

                foreach ($update as &$fields_slug)
                {
                    if (in_array($fields_slug, $fields_slugs))
                    {
                        $fields_slug = $namespace . '_' . $stream_slug . '_' . $fields_slug;
                    }
                }

                unset($fields_slug);

                $this->streams->streams->update_stream($stream_slug, $namespace, array('view_options' => $update));
            }
        }

        return true;
    }

    public function uninstall()
    {
        $this->uninstall_streams();

        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }
}