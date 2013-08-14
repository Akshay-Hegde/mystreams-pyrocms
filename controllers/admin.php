<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    // pretty much copy&paste from FAQ module

    protected $section;

    private $options;

    private $dir;

    public function __construct()
    {
        $this->config->load('mystreams');
        $streams = $this->config->item('mystreams');
        $this->dir = $this->config->item('mystreams_dir');

        $this->section = ($this->uri->uri_string() == 'admin/' . $this->dir) ? key($streams) : $this->uri->segment(3);

        parent::__construct();

        $this->lang->load('mystreams');

        $this->options = $streams[$this->section];
    }

    public function index()
    {
        $extra = array();

        $extra['title'] = $this->options['name'] . ' | MyStreams';

        $extra['buttons'] = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/' . $this->dir . '/' . $this->section . '/edit/-entry_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/' . $this->dir . '/' . $this->section . '/delete/-entry_id-',
                'confirm' => true
            )
        );

        $extra['sorting'] = true;

        $this->streams->cp->entries_table($this->section, $this->options['namespace'], 0, 'admin/' . $this->dir . '/' . $this->section, true, $extra);
    }

    public function create()
    {
        $extra = array(
            'return' => 'admin/' . $this->dir . '/' . $this->section,
            'success_message' => lang('mystreams:success'),
            'failure_message' => lang('mystreams:error'),
            'title' => $this->options['name'] . ' | ' . lang('mystreams:create') . ' | MyStreams'
        );

        $this->streams->cp->entry_form($this->section, $this->options['namespace'], 'new', null, true, $extra);
    }

    public function edit($id = 0)
    {
        $extra = array(
            'return' => 'admin/' . $this->dir . '/' . $this->section,
            'success_message' => lang('mystreams:success'),
            'failure_message' => lang('mystreams:error'),
            'title' => $this->options['name'] . ' | ' . lang('mystreams:edit') . ' | MyStreams'
        );

        $this->streams->cp->entry_form($this->section, $this->options['namespace'], 'edit', $id, true, $extra);
    }

    public function delete($id = 0)
    {
        $this->streams->entries->delete_entry($id, $this->section, $this->options['namespace']);
        $this->session->set_flashdata('success', lang('mystreams:delete'));

        redirect('admin/' . $this->dir . '/' . $this->section);
    }
}