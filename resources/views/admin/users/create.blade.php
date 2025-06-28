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
?>
@extends('admin.layouts.main')
@section('title','Create - Admin Users')

@push('css')
<style>
    #users_create_page .input-group-text{
        border-left: 0;
    }
</style>
@endpush

@push('scripts')
<script src="{{url('/')}}/assets/admin/users/js/create.js?v={{time()}}" type="text/javascript"></script>

<script type="text/javascript">
const  mode = '<?php echo isset($mode) ? $mode : 'save'; ?>';
const  key = '<?php echo isset($key) ? $key : ''; ?>';
const  module = '<?php echo (isset($module)) ? $module : 'admin'; ?>';

globals.modules.attach(usersCreate);
</script>
@endpush

@section('content')
<div class="container-xl" id="users_create_page">
    <!--Page header-->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">Create</div>
                    <h2 class="page-title">Admin Users</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn">New view</a>
                        </span>
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new report
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--./Page header-->

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Enter basic details</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off">
                            <div class="form-group row mb-3 ">
                                <div class="col-md-4 mx-0">
                                    <label class="form-label">First Name</label>
                                    <div>
                                        <input type="text" id="fname" v-model="model.fname" class="form-control"  placeholder="Enter Name" autocomplete="off" />
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mx-0">
                                    <label class="form-label">Last Name</label>
                                    <div>
                                        <input type="text" id="lname" v-model="model.lname" class="form-control"  placeholder="Enter Name" autocomplete="off" />
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mx-0">
                                    <label class="form-label">Middle Name</label>
                                    <div>
                                        <input type="text" id="mname" v-model="model.mname" class="form-control"  placeholder="Enter Name" autocomplete="off" />
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3 ">
                                <label class="form-label">Mobile Number</label>
                                <div>
                                    <input type="text" id="mobile" v-model="model.mobile" class="form-control"  placeholder="Enter Contact Number" autocomplete="off" />
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            <div class="form-group mb-3 ">
                                <label class="form-label">Email address</label>
                                <div>
                                    <input type="text" id="email" v-model="model.email" class="form-control" placeholder="Enter Email address" autocomplete="off" />
                                    <small class="form-hint">We'll never share your email with anyone else.</small>
                                </div>
                            </div>
                            <div class="form-group mb-3 ">
                                <label class="form-label">Login Name/Username</label>
                                <div>
                                    <input type="text" id="login_name" v-model="model.login_name" class="form-control"  placeholder="Enter Login Name/Username" autocomplete="off" />
                                    <span class="text-danger error"></span>                                    
                                </div>
                            </div>                            
                            <div class="form-group1 mb-3 ">
                                <label class="form-label">Password</label>                                
                                <div class="input-group input-group-flat">                                      
                                    <input type="password" id="password" v-model="model.password" v-if="!show_password" class="form-control" placeholder="Enter Password"  autocomplete="off" />
                                    <input type="text" id="password" v-model="model.password" v-if="show_password" class="form-control" placeholder="Enter Password" autocomplete="off" />
                                    <span class="input-group-text">
                                        <a v-if="!show_password" v-on:click="show_password=!show_password" class="input-group-link" style="cursor: pointer;">Show password</a>
                                        <a v-if="show_password" v-on:click="show_password=!show_password" class="input-group-link" style="cursor: pointer;">Hide password</a>
                                    </span>
                                </div>
                                <span class="text-danger error"></span>
                                <small class="form-hint">
                                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain
                                    spaces, special characters, or emoji.
                                </small>
                            </div>
                            <div class="form-group mb-3 ">
                                <label class="form-label">Status</label>
                                <div>
                                    <select id="status" v-model="model.status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>   
                            <div class="form-group mb-3 ">
                                <label class="form-label">Remarks</label>
                                <div>
                                    <textarea id="remarks" v-model="model.remarks" class="form-control" rows="8" placeholder="Enter Remarks"></textarea>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button type="button" class="btn btn-primary" onclick="usersCreate.save()">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection