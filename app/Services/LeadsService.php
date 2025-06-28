<?php

/*
 *  To change this license header, choose License Headers in Project Properties.
 *  To change this template file, choose Tools | Templates
 *  and open the template in the editor.

 *  Licensed to the Apache Software Foundation (ASF) under one or more
 *  contributor license agreements. See the NOTICE file distributed with
 *  this work for additional information regarding copyright ownership.
 *  The ASF licenses this file to You under the Apache License, Version 2.0
 *  (the "License"); you may not use this file except in compliance with
 *  the License. You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 * 
 *  Developer: Pranata Naskar (pranata.naskar@gmail.com)
 *  
 * 
 */

namespace App\Services;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\AppGlobals;
use App\Models\Leads;
use App\Models\Users;

/**
 * Description of LeadsService
 *
 * @author Pranata
 */
class LeadsService {

    private $request;
    private $response;
    private $model;
    private $columns;

    public function __construct() {
        $this->request = request();
        $this->model = new Leads();
        $this->columns = Schema::getColumnListing($this->model->getTable());
        $this->columns = array_diff($this->columns, ['lead_indx', 'lead_id', 'lead_create_date', 'lead_update_date', 'lead_delete']);

        $this->response[ 'msg' ] = 'error';
        $this->response[ 'code' ] = '100';
        $this->response[ 'data' ] = 'error';
        $this->response[ 'inputs' ] = $this->request->input();
    }

    /**
     * 
     * @return $this
     */
    public static function call($class = __CLASS__) {
        return (new $class);
    }

    public function create($inputs) {
        foreach ($this->columns as $column) {
            $index = str_replace('lead_', "", $column);
            if ($index != 'indx')
                $this->model->{$column} = isset($inputs[ $index ]) ? $inputs[ $index ] : null;
        }

        $this->model->lead_id = "LED" . AppGlobals::autoKey($this->model);
        $this->model->lead_status = isset($inputs[ 'status' ]) ? $inputs[ 'status' ] : 'new';

        if ($this->model->save()) {
            $this->model->refresh();
            $this->response[ 'msg' ] = 'success';
            $this->response[ 'code' ] = "0";
            $this->response[ 'data' ] = $this->model->get_params();
        } else {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'code' ] = "2";
            $this->response[ 'data' ] = "error";
        }

        return $this->response;
    }

    public function update($inputs) {
        $key = isset($this->request->key) ? $this->request->key : '';

        if ($key == '') {
            $this->response[ 'msg' ] = "error";
            $this->response[ 'code' ] = 1;
            $this->response[ 'data' ] = "Invalid key.";
            return $this->response;
        }

        $this->model = Leads::find($key);

        if ($this->model == null) {
            $this->response[ 'msg' ] = "error";
            $this->response[ 'code' ] = 2;
            $this->response[ 'data' ] = "Data not found.";
            return $this->response;
        }

        foreach ($this->columns as $column) {
            $index = str_replace('lead_', "", $column);
            if ($index != 'indx')
                $this->model->{$column} = isset($inputs[ $index ]) ? $inputs[ $index ] : $this->model->{$column};
        }

        if ($this->model->update()) {
            $this->model->refresh();
            $this->response[ 'msg' ] = 'success';
            $this->response[ 'code' ] = "0";
            $this->response[ 'data' ] = $this->model->get_params();
        } else {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'code' ] = "2";
            $this->response[ 'data' ] = "error";
        }

        return $this->response;
    }

    public function view($inputs) {
        $key = isset($this->request->key) ? $this->request->key : '';
        $data = [];

        $this->model = Leads::find($key);

        if (!empty($this->model) && $this->model !== null) {
            $data = $this->model->get_params();
            $this->response[ 'msg' ] = 'success';
            $this->response[ 'code' ] = '0';
            $this->response[ 'data' ] = $data;
        } else {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'code' ] = '1';
            $this->response[ 'data' ] = 'No Records Found';
        }

        return $this->response;
    }

    public function search($inputs) {
        $data = [];

        $results_per_page = isset($inputs[ 'results_per_page' ]) ? $inputs[ 'results_per_page' ] : 10;
        $page = (isset($inputs[ 'page' ]) && $inputs[ 'page' ] >= 1) ? $inputs[ 'page' ] : 1;
        $offset = ($page - 1) * $results_per_page;

        $sort_by = isset($inputs[ 'sort_by' ]) ? "lead_" . $inputs[ 'sort_by' ] : 'lead_indx';
        $sort_order = isset($inputs[ 'sort_order' ]) ? $inputs[ 'sort_order' ] : 'DESC';

        $search = isset($inputs[ 'search' ]) ? $inputs[ 'search' ] : '';
        $status = isset($inputs[ 'status' ]) ? $inputs[ 'status' ] : '';
        $type = isset($inputs[ 'type' ]) ? $inputs[ 'type' ] : '';
        $key = isset($inputs[ 'key' ]) ? $inputs[ 'key' ] : '';

        $query = Leads::select('*')->where('lead_delete', '=', 'N');

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where("lead_id", 'LIKE', "%{$search}%");
                $builder->orWhere("lead_email", 'LIKE', "%{$search}%");
            });
        }

        if ($status !== '') {
            $query->where('lead_status', 'LIKE', "{$status}");
        }

        if ($type !== '') {
            $query->where('lead_type', 'LIKE', "{$type}");
        }

        if ($key !== '') {
            $query->where('lead_id', 'LIKE', "{$key}");
        }

        $totalResults = $query->count();

        $results = $query->offset($offset)
                ->limit($results_per_page)
                ->orderBy($sort_by, $sort_order)
                ->get();

        foreach ($results as $row) {
            $data[] = $row->get_params();
        }

        $number_of_page = intval($totalResults / $results_per_page);
        $number_of_page = (($totalResults % $results_per_page) > 0) ? $number_of_page + 1 : $number_of_page;

        $pagination = [
            'pages' => $number_of_page,
            'page' => $page,
            'count' => $totalResults,
            'offset' => $offset,
        ];

        $this->response[ 'msg' ] = 'success';
        $this->response[ 'code' ] = "0";
        $this->response[ 'data' ] = $data;
        $this->response[ 'pagination' ] = $pagination;

        return $this->response;
    }

    public function delete($inputs) {
        $key = isset($this->request->key) ? $this->request->key : '';

        if ($count = Leads::where('lead_id', '=', $key)->update(['lead_delete' => 'Y'])) {
            $this->response[ 'msg' ] = 'success';
            $this->response[ 'code' ] = '0';
            $this->response[ 'data' ] = $count;
        } else {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'code' ] = '2';
            $this->response[ 'data' ] = 'error';
        }

        return $this->response;
    }
}
