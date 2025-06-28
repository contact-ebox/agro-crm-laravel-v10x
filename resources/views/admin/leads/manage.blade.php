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
@section('title','Leads - '.  ($title ?? '') )

@push('css')
<link href="{{url('')}}/plugins/jquery-easyui/themes/gray/easyui.css" rel="stylesheet" type="text/css"/>
<link href="{{url('')}}/plugins/jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
<script src="{{url('')}}/plugins/jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
<script src="{{url('')}}/plugins/jquery-easyui/jquery.easyui.mobile.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/admin/leads/js/manage.js?v={{time()}}" type="text/javascript"></script>

<script type="text/javascript">
const  mode = '<?php echo isset($mode) ? $mode : 'save'; ?>';
const  key = '<?php echo isset($key) ? $key : ''; ?>';
const  module = '<?php echo (isset($module)) ? $module : 'admin'; ?>';

globals.modules.attach(leads);
</script>
@endpush

@section('content')
<div class="container-xl" id="leads_page">
    <!--Page header-->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">Manage</div>
                    <h2 class="page-title">Admin Users</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn">New view</a>
                        </span>
                        <a href="{{route('admin.users.create')}}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" /> 
                            </svg>
                            Create a Admin User
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                           data-bs-target="#modal-report" aria-label="Create new report">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" style="min-height: 300px;">
                            <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>NO.
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-dark icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                                 stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="6 15 12 9 18 15"></polyline>
                                            </svg>
                                        </th>
                                        <th>Name</th>
                                        <th>Pho.No</th>                                        
                                        <th>Enquiry For</th>
                                        <th>Lead Given</th>
                                        <th>Lead Type</th>
                                        <th>Lead Status</th>
                                        <th>Date</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, indx) in rows">
                                        <td data-label="No" v-bind:data-key="row.key">@{{row.indx}}</td>
                                        <td data-label="Name">@{{row.name}}</td>
                                        <td data-label="Pho.No">
                                            <div>@{{row.phone}}</div>
                                            <!--<div class="text-muted">Business Development</div>-->
                                        </td>
                                        <td class="text-muted" data-label="Enquiry For">@{{row.email}}</td>
                                        <td class="text-muted" data-label="Lead Given">@{{row.enquiry_for}}</td>
                                        <td class="text-muted" data-label="Lead Type">DSC1</td>
                                        <td class="text-muted" data-label="Lead Status">@{{row.type}}</td>
                                        <td class="text-muted" data-label="Create Date">@{{row.create_date2}}</td>
                                        <td>
                                            <div class="btn-list flex-nowrap">                                                
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a v-on:click="update(indx)" class="dropdown-item" style="cursor: pointer;" >Edit</a>
                                                        <a v-on:click="confirm_delete(indx)" class="dropdown-item text-danger" style="cursor: pointer;">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        <ul class="pagination mb-0"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--delete-->
    <div class="modal modal-blur fade" id="mdl_delete" tabindex="-1" aria-modal="true" >
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path>
                        <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                    <h3>Are you sure?</h3>
                    <div class="text-secondary" v-if="selected_row.key != undefined">
                        Do you really want to remove <b>@{{selected_row.title}}</b>? What you've done cannot be undone.
                    </div>
                </div>
                <div class="modal-footer" v-if="selected_row.key != undefined">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
                            <div class="col"><a class="btn btn-danger w-100" onclick="users.delete()">Delete</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--delete-->
</div>
@endsection

