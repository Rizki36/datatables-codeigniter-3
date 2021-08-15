<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatables extends CI_Controller
{

    public function index()
    {
        $this->load->view('v_datatables');
    }

    public function get_data()
    {
        $this->load->model('M_Datatables');
        $configData = $this->input->post();

        ## table
        $configData['table'] = 'shipment_trx';

        ## join
        $configData['join'] = [
            [
                'table' => 'mst_person',
                'on' => 'mst_person.person_code = shipment_trx.person_code',
                'param' => 'left'
            ]
        ];

        ## where -> has effect with total row
        $configData['where'] = [
            ['shipment_trx.person_code' => 'PRS-000001']
        ];

        ## custom filter -> has effect with total filtered row 
        // $configData['filters'][] = ['shipment_status' => 'AKTIF'];

        ## select -> fill with all column you need
        $configData['selected_column'] = [
            'awb_no',
            'person_name',
            'pickup_name',
            'pickup_address',
            'customer_code',
            'pickup_district_code',
            'tgl_transaksi'
        ];

        ## display column -> Represent column in view
        // index must same with table column
        // set false if column not in db table (column number, action, etc)
        $configData['display_column'] = [
            false,
            'awb_no',
            'person_code',
            'pickup_name',
            'pickup_address',
            'customer_code',
            'tgl_transaksi'
        ];

        ## get data
        $data = $this->M_Datatables->get_data($configData);

        $records = $data['records'];

        $data['data'] = [];
        $num_start_row = $configData['start'];
        foreach ($records as $record) {
            $temp = [];
            $temp[] = ++$num_start_row;
            $temp[] = $record->awb_no;
            $temp[] = $record->person_name;
            $temp[] = $record->pickup_name;
            $temp[] = $record->pickup_address;
            $temp[] = $record->customer_code;
            $temp[] = $record->tgl_transaksi;

            $data['data'][] = $temp;
        }
        unset($data['records']);

        echo json_encode($data);
    }
}
