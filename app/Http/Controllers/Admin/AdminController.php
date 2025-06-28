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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller {

    private $request;
    private $response;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->response[ 'inputs' ] = $this->request->input();

        view()->share('store_configs', [
            'name' => env('APP_NAME'),
        ]);

        return true;
    }

    public function dashboard() {
        return view('admin.dashboard.dashboard');
    }

    public function users_manage() {
        return view('admin.users.manage');
    }

    public function users_create() {
        return view('admin.users.create', [
            'mode' => 'save',
            'key' => '',
        ]);
    }

    public function users_update() {
        $key = isset($this->request->key) ? $this->request->key : '';
        $inputs = $this->request->input();

        return view('admin.users.create', [
            'mode' => 'update',
            'key' => $key,
        ]);
    }

    public function leads_manage() {
        $title = "Manage";

        return view('admin.leads.manage', [
            'mode' => 'update',
            'title' => $title,
        ]);
    }

    public function leads_total() {
        $title = "Manage";

        return view('admin.leads.manage', [
            'mode' => 'update',
            'title' => $title,
        ]);
    }
}
