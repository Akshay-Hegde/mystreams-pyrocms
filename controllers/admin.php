<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    // pretty much copy&paste from FAQ module

    protected $section;

    private $namespace;
    private $module_name;
    private $streams_data;

    public function __construct()
    {
        $this->config->load('mystreams');
        $this->streams_data = $this->config->item('mystreams');

        $this->section = $this->uri->segment(4);
        $this->namespace = $this->uri->segment(3);

        if ( ! $this->section)
        {
            $this->namespace = key($this->streams_data);
            $this->section = key($this->streams_data[$this->namespace]);
        }

        $this->module_name = $this->uri->segment(2);

        parent::__construct();

        $this->lang->load('mystreams');
    }

    public function index()
    {
        $extra = array();

        $extra['title'] = $this->streams_data[$this->namespace][$this->section]['name'] . ' [' . $this->namespace . '] | ' . ucfirst($this->module_name);

        $extra['buttons'] = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/' . $this->module_name . '/' . $this->namespace . '/' . $this->section . '/edit/-entry_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/' . $this->module_name . '/' . $this->namespace . '/' . $this->section . '/delete/-entry_id-',
                'confirm' => true
            )
        );

        $extra['sorting'] = true;

        $this->streams->cp->entries_table($this->section, $this->namespace, 0, 'admin/mystreams/' . $this->namespace . '/' . $this->section, true, $extra);
    }

    public function create()
    {
        $extra = array(
            'return' => 'admin/' . $this->module_name . '/' . $this->namespace . '/' . $this->section,
            'success_message' => lang('mystreams:success'),
            'failure_message' => lang('mystreams:error'),
            'title' => $this->streams_data[$this->namespace][$this->section]['name'] . ' [' . $this->namespace . '] | ' . lang('mystreams:create') . ' | ' . ucfirst($this->module_name)
        );

        $this->streams->cp->entry_form($this->section, $this->namespace, 'new', null, true, $extra);
    }

    public function edit($id = 0)
    {
        $extra = array(
            'return' => 'admin/' . $this->module_name . '/' . $this->namespace . '/' . $this->section,
            'success_message' => lang('mystreams:success'),
            'failure_message' => lang('mystreams:error'),
            'title' => $this->streams_data[$this->namespace][$this->section]['name'] . ' [' . $this->namespace . '] | ' . lang('mystreams:edit') . ' | ' . ucfirst($this->module_name)
        );

        $this->streams->cp->entry_form($this->section, $this->namespace, 'edit', $id, true, $extra);
    }

    public function delete($id = 0)
    {
        $this->streams->entries->delete_entry($id, $this->section, $this->namespace);
        $this->session->set_flashdata('success', lang('mystreams:delete'));

        redirect('admin/' . $this->module_name . '/' . $this->namespace . '/' . $this->section);
    }
}