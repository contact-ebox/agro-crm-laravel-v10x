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

use App\Models\Users;
use App\Models\AppGlobals;
use Illuminate\Support\Facades\Schema;

/**
 * Description of UsersService
 *
 * @author Joy
 * 
 */
class UsersService {

    private $request;
    private $response;

    /**
     *
     * @var Users   
     */
    private $model;
    private $columns;

    /**
     * 
     * @param Request $request
     * @param \App\Http\Controllers\Redirector $redirect
     * @return Users
     */
    public function __construct() {
        $this->request = request();
        $this->model = new Users();
        $this->columns = Schema::getColumnListing($this->model->getTable());
        $this->columns = array_diff($this->columns, ['user_indx', 'user_key', 'user_create_date', 'user_update_date', 'user_delete',]);

        $this->response[ 'msg' ] = 'error';
        $this->response[ 'code' ] = '100';
        $this->response[ 'data' ] = 'error';

        return $this;
    }

    /**
     * 
     * @return $this
     */
    public static function call($class = __CLASS__) {
        return (new $class);
    }

    public function create($inputs) {
        foreach ($this->columns as $key => $column) {
            $index = str_replace('user_', "", $column);

            if ($index != 'indx')
                $this->model->{$column} = (isset($inputs[ $index ])) ? $inputs[ $index ] : null;
        }

        $this->model->user_key = "ADMU" . AppGlobals::autoKey($this->model);
        $this->model->user_status = (isset($inputs[ 'status' ])) ? $inputs[ 'status' ] : AppGlobals::active;
        $this->model->user_password = (isset($inputs[ 'password' ])) ? md5($inputs[ 'password' ]) : '';
        $this->model->user_permissions = (isset($inputs[ 'permissions' ])) ? json_encode($inputs[ 'permissions' ]) : json_encode([]);
        $this->model->user_image = (isset($inputs[ 'image' ])) ? json_encode($inputs[ 'image' ]) : json_encode([]);

        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'login_name' => "required|unique:\App\Models\Users,user_login_name|max:200",
            //'profile' => "required|email|unique:\App\Models\Users,user_profile|max:200",
            'password' => 'required',
        ];
        $messages = [
            'fname.required' => 'Enter First name',
            'lname.required' => 'Enter Last name',
            'login_name.required' => 'Enter an username',
            'login_name.unique' => 'This username is already in use',
            //'profile.required' => 'Enter an email',
            //'profile.unique' => 'This email is already in use',
            'password.required' => 'Please enter a password',
        ];

        $validator = validator($inputs, $rules, $messages);

        if ($validator->fails()) {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'code' ] = '1';
            $this->response[ 'data' ] = $validator->errors();

            echo json_encode($this->response);
            exit();
        }

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
        $key = (isset($this->request->key)) ? $this->request->key : '';

        if ($key == '') {
            $this->response[ 'msg' ] = "error";
            $this->response[ 'code' ] = 1;
            $this->response[ 'data' ] = "Invalid key.";

            return $this->response;
        }

        $this->model = Users::find($key);

        if ($this->model == null) {
            $this->response[ 'msg' ] = "error";
            $this->response[ 'code' ] = 2;
            $this->response[ 'data' ] = "Data not found.";

            return $this->response;
        }

        $rules = [
            'name' => 'required',
            'login_name' => "required|unique:\App\Models\Users,user_login_name|max:200",
            'profile' => "required|email|unique:\App\Models\Users,user_profile|max:200",
            'password' => 'required',
        ];
        $messages = [
            'name.required' => 'Enter name',
            'login_name.required' => 'Enter an username',
            'login_name.unique' => 'This username is already in use',
            'profile.required' => 'Enter an email',
            'profile.unique' => 'This email is already in use',
            'password.required' => 'Please enter a password',
        ];

        $validator = validator($inputs, $rules, $messages);

        /* if ($validator->fails()) {
          $this->response['msg'] = 'error';
          $this->response['code'] = '1';
          $this->response['data'] = $validator->errors();

          echo json_encode($this->response);
          exit();
          } */

        foreach ($this->columns as $key => $column) {
            $index = str_replace('user_', "", $column);

            if ($index != 'indx')
                $this->model->{$column} = (isset($inputs[ $index ])) ? $inputs[ $index ] : $this->model->{$column};

            //$data[$index] = $value;
        }

        $this->model->user_password = (isset($inputs[ 'password' ])) ? md5($inputs[ 'password' ]) : $this->model->user_password;

        if ($this->model->update()) {
            $this->model->refresh();

            $this->response[ 'msg' ] = 'success';
            $this->response[ 'code' ] = "0";
            $this->response[ 'data' ] = $this->model->get_params([]);
        } else {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'code' ] = "2";
            $this->response[ 'data' ] = "error";
        }

        return $this->response;
    }

    public function view($inputs) {
        $key = ($this->request->key) ? $this->request->key : '';
        $data = [];

        /* @var $model Users */

        $this->model = Users::find($key);

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
        $page = (isset($inputs[ 'page' ]) && $inputs[
                'page' ] >= 1) ? $inputs[ 'page' ] : 1;
        $offset = ($page - 1) * $results_per_page;

        $sort_by = 'user_indx'; // isset($inputs['sort_by']) ? $this->sort_by($inputs['sort_by']) : 'user_indx';
        $sort_order = isset($inputs[ 'sort_order' ]) ? $inputs[ 'sort_order' ] : 'DESC';

        $search = isset($inputs[ 'search' ]) ? $inputs[ 'search' ] : '';
        $status = isset($inputs[ 'status' ]) ? $inputs[ 'status' ] : '';
        $type = isset($inputs[ 'type' ]) ? $inputs[ 'type' ] : '';
        $key = isset($inputs[ 'key' ]) ? $inputs[ 'key' ] : '';
        $name = isset($inputs[ 'name' ]) ? $inputs[ 'name' ] : '';
        $title = isset($inputs[ 'title' ]) ? $inputs[ 'title' ] : '';
        $with = isset($inputs[ 'with' ]) ? $inputs[ 'with' ] : [];

        $query1 = Users::select('*')->where('user_delete', '=', AppGlobals::No);

        if ($search !== '') {
            $query1->where(function ($builder) use ($inputs, $search) {
                /* @var $builder \Illuminate\Database\Schema\Builder */
                $builder->where("user_name", 'LIKE', "%{$search}%");
                $builder->orWhere("user_title", 'LIKE', "%{$search}%");
                $builder->orWhere("user_description", 'LIKE', "%{$search}%");

                return $builder;
            });
        }

        if ($status !== '') {
            $query1->where('user_status', 'LIKE', "{$status}");
        }

        if ($type !== '') {
            $query1->where('user_type', 'LIKE', "{$type}");
        }

        if ($key !== '') {
            $query1->where('user_key', 'LIKE', "{$key}");
        }

        if ($name !== '') {
            $query1->where('user_name', 'LIKE', "%{$name}%");
        }

        if ($title !== '') {
            $query1->where('user_title', 'LIKE', "%{$title}%");
        }

        $query2 = $query1;
        $model1 = $query1->get();

        $model2 = $query2->offset($offset)
                ->limit($results_per_page)
                ->orderBy($sort_by, $sort_order)
                ->get();

        /* @var $category Users */
        foreach ($model2 as $indx => $category) {
            $data[] = $category->get_params([]);
        }

        //determine the total number of pages available  
        $number_of_result = count($model1); //mysqli_num_rows($result);
        $number_of_page = intval($number_of_result / $results_per_page);  //ceil($number_of_result / $results_per_page);
        $number_of_page = (($number_of_result % $results_per_page) > 0) ? $number_of_page + 1 : $number_of_page;

        $pagination = [
            'pages' => $number_of_page,
            'page' => $page,
            'count' => $number_of_result,
            'offset' => $offset,
        ];

        $this->response[ 'msg' ] = 'success';
        $this->response[ 'code' ] = "0";
        $this->response[ 'data' ] = $data;
        $this->response[ 'pagination' ] = $pagination;

        return $this->response;
    }

    public function delete($inputs) {
        // $key = isset($inputs['key']) ? $inputs['key'] : '';
        $key = isset($this->request->key) ? $this->request->key : '';
        $keys = isset($inputs[ 'keys' ]) ? $inputs[ 'keys' ] : [];

        if ($count = Users::where('user_key', '=', $key)->update(['user_delete' => AppGlobals::Yes])) {
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

    public function signin($inputs) {
        $username = (isset($inputs[ 'username' ])) ? $inputs[ 'username' ] : '';
        $password = (isset($inputs[ 'password' ])) ? $inputs[ 'password' ] : '';

        $this->model = Users::where('user_login_name', '=', "{$username}")
                ->orderBy('user_indx', 'DESC')
                ->first();

        if ($this->model == null) {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'data' ] = 'Incorrect username';
            $this->response[ 'code' ] = "1";

            return $this->response;
        }

        if ($this->model->user_password == md5($password)) {
            $this->response[ 'msg' ] = 'success';
            $this->response[ 'data' ] = [
                "key" => base64_encode($this->model->user_key),
                "username" => $this->model->user_login_name,
                "email" => $this->model->user_profile,
                'name' => $this->model->name(),
            ];
            $this->response[ 'code' ] = "0";
        } else {
            $this->response[ 'msg' ] = 'error';
            $this->response[ 'data' ] = 'Incorrect Password';
            $this->response[ 'code' ] = "2";
        }

        return $this->response;
    }
}
