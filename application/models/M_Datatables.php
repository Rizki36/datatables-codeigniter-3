<?php
defined('BASEPATH') or exit('No direct script access allowed');


class M_Datatables extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_data($postData = null)
    {
        $response = array();

        $table = $postData['table'];
        $selectedColumn = isset($postData['selected_column']) ? $postData['selected_column'] : '*';

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndexOrder = $postData['order'][0]['column']; // Column index order
        $columnIndex = $postData['columns'][$columnIndexOrder]['data']; // Column index table
        $columnName = $postData['display_column'][$columnIndex]; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        $whereQuery = "";

        ## Search  
        $search_arr = array();
        if ($searchValue != '') {
            $searchQuery = [];
            $displayColumn = $postData['display_column'];
            foreach ($displayColumn as $indexColumn => $column) {
                if ($column !== false) { // check display column is true column
                    if ($postData['columns'][$indexColumn]['searchable'] === 'true') { // check is searchable column
                        $searchQuery[] = "$column Like '%$searchValue%'";
                    }
                }
            }

            $searchQuery = implode(' OR ', $searchQuery);
            $search_arr[] = "($searchQuery)";
        }


        ## Filter
        if (isset($postData['filters'])) {
            /**
             * $postData['filters'] = [
             *    "key <= 'value'", // string filter, for column (last then, greather then, etc) value 
             *    ['key' => 'value'] // array filter, for column equal value
             * ]
             */
            foreach ($postData['filters'] as $filter) {
                if (is_string($filter)) {
                    $search_arr[] = $filter;
                } else if (is_array($filter)) {
                    foreach ($filter as $key => $value) {
                        $search_arr[] = "$key = '$value'";
                    }
                }
            }
        }
        if (count($search_arr) > 0) {
            $whereQuery = implode(" and ", $search_arr);
        }



        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        if (isset($postData['join'][0])) {
            foreach ($postData['join'] as $key => $value) {
                $this->db->join($value['table'], $value['on'], $value['param']);
            }
        }
        if (isset($postData['where'][0])) {
            foreach ($postData['where'] as $key => $value) {
                $this->db->where($value);
            }
        }
        $records = $this->db->get($table)->result();
        $totalRecords = $records[0]->allcount;


        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if (isset($postData['join'][0])) {
            foreach ($postData['join'] as $key => $value) {
                $this->db->join($value['table'], $value['on'], $value['param']);
            }
        }
        if (isset($postData['where'][0])) {
            foreach ($postData['where'] as $key => $value) {
                $this->db->where($value);
            }
        }
        if ($whereQuery != '') {
            $this->db->where($whereQuery);
        }
        $records = $this->db->get($table)->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select($selectedColumn);
        if (isset($postData['join'][0])) {
            foreach ($postData['join'] as $key => $value) {
                $this->db->join($value['table'], $value['on'], $value['param']);
            }
        }
        if (isset($postData['where'][0])) {
            foreach ($postData['where'] as $key => $value) {
                $this->db->where($value);
            }
        }
        if ($whereQuery != '') {
            $this->db->where($whereQuery);
        }
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get($table)->result();


        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "records" => $records
        );

        return $response;
    }
}
