<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_Mystreams extends Plugin
{
    public $version = '1.2.0';

    public $name = array(
        'en' => 'MyStreams',
    );

    public $description = array(
        'en' => 'Plugin for displaying streams',
    );

    // gets stream entries
    public function cycle($params = false)
    {
        $params = ($params) ? $params : $this->attributes();

        $streams_config = $this->config->item('mystreams');

        // set defaults
        $params['namespace'] = (isset($params['namespace'])) ? $params['namespace'] : key($streams_config);
        $params['order_by'] = (isset($params['order_by'])) ? $params['order_by'] : 'ordering_count';
        $params['sort'] = (isset($attributes['sort'])) ? $attributes['sort'] : 'asc';

        $stream_data = $this->streams->entries->get_entries($params);
        //$entries = $stream_data['entries'];

        $fields = $streams_config[$params['namespace']][$params['stream']]['fields'];

        foreach ($stream_data['entries'] as &$entry)
        {
            foreach ($fields as $field)
            {
                $slug = $field['slug'];
                $db_slug = $params['namespace'] . '_' . $params['stream'] . '_' . $field['slug'];

                if ($field['type'] != 'relationship')
                {
                    $entry[$slug] = $entry[$db_slug];
                }
                else
                {
                    $relation_stream = $field['extra']['choose_stream'];

                    $relation_fields = $streams_config[$params['namespace']][$relation_stream]['fields'];

                    foreach ($relation_fields as $relation_field)
                    {
                        if (isset($relation_field['title_column']) and $relation_field['title_column'] == true)
                        {
                            $relation_slug = $relation_field['slug'];

                            break;
                        }
                    }

                    if (isset($relation_slug))
                    {
                        $relation_db_slug = $params['namespace'] . '_' . $relation_stream . '_' . $relation_slug;

                        $entry[$slug] = $entry[$db_slug][$relation_db_slug];
                    }
                }
            }
        }

        unset($entry);

        return array($stream_data);
    }

    // for testing streams in development stage
    public function test()
    {
        $stream_data = $this->cycle($this->attributes());

        return '<pre>' . print_r($stream_data, true) . '</pre>';
    }
}