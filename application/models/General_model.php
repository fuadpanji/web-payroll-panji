<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIdentity() // Identity of System *Important
    {
        return $this->db->get('settings')->row_array();
    }

    public function updateSettings($id)
    {
        $data =
            [
                'company' => $this->input->post('company', true) ?: $this->getIdentity()['company'],
                'signin_time' => $this->input->post('start_work_time', true) ?: $this->getIdentity()['start_work_time'],
                'signout_time' => $this->input->post('end_work_time', true) ?: $this->getIdentity()['end_work_time'],
                'fixed_incentives' => $this->input->post('fixed_incentives', true) ?: $this->getIdentity()['fixed_incentives'],
                'additional_incetives' => $this->input->post('additional_incetives', true) ?: $this->getIdentity()['additional_incetives'],
                'annual_working_hours' => $this->input->post('annual_working_hours', true) ?: $this->getIdentity()['annual_working_hours'],
                'NWNP_deduction' => $this->input->post('NWNP_deduction', true) ?: $this->getIdentity()['NWNP_deduction'],
                'BPJS_deduction' => $this->input->post('BPJS_deduction', true) ?: $this->getIdentity()['BPJS_deduction'],
            ];

        $this->db->update("settings", $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
