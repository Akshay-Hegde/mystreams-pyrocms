<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_Mystreams extends Plugin
{
    public $version = '1.0.0';

    public $name = array(
        'en' => 'MyStreams',
    );

    public $description = array(
        'en' => 'Plugin for displaying streams',
    );

    private $dir;

    public function __construct()
    {
        // use for default namespace
        $this->dir = $this->config->item('mystreams_dir');
    }

    // gets stream entries
    public function cycle()
    {
        $params = $this->attributes();

        // set default params
        $params['namespace'] = (isset($params['namespace'])) ? $params['namespace'] : $this->dir;
        $params['order_by'] = (isset($params['order_by'])) ? $params['order_by'] : 'ordering_count';
        $params['sort'] = (isset($attributes['sort'])) ? $attributes['sort'] : 'asc';

        $entries = $this->streams->entries->get_entries($params);

        return $entries['entries'];
    }

    // gets single stream entry
    // nested variables are not working, use cycle with where param
    public function single()
    {
        $id = $this->attribute('id');
        $stream = $this->attribute('stream');
        $namespace = $this->attribute('namespace');
        $namespace = ($namespace) ? $namespace : $this->dir;

        return (array)$this->streams->entries->get_entry($id, $stream, $namespace);
    }
}