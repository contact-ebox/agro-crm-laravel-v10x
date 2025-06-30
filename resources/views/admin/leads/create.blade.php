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
<link href="{{url('')}}/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>
<link href="{{url('')}}/plugins/jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css"/>

<style>
    .date-range-picker .clear{
        position: relative;
        right: 24px;
        top: 2px;
        font-size: 20px;
        font-weight: 500;
        line-height: 36px;
        cursor: pointer;
    }
    .date-range-picker .clear:hover{
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{url('')}}/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="{{url('')}}/plugins/jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
<script src="{{url('')}}/plugins/jquery-easyui/jquery.easyui.mobile.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/admin/leads/js/create.js?v={{time()}}" type="text/javascript"></script>

<script type="text/javascript">
const  mode = '<?php echo isset($mode) ? $mode : 'save'; ?>';
const  key = '<?php echo isset($key) ? $key : ''; ?>';
const  module = '<?php echo (isset($module)) ? $module : 'admin'; ?>';

globals.modules.attach(leadsCreate);
</script>
@endpush

@section('content')
<div class="container-xl" id="lead_create_page">
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
                        <a id="ancr_show_leads_form"  class="btn btn-primary d-sm-inline-block" style="cursor: pointer;">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" /> 
                            </svg>
                            View Leads
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
            <div class="d-flex row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" v-model="model.name" class="form-control" placeholder="Input placeholder" />
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="text" id="email" name="email" v-model="model.email" class="form-control" placeholder="Input placeholder" />
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone No. <span class="text-danger">*</span></label>
                                        <input type="text"id="phone" name="phone" v-model="model.phone" class="form-control" placeholder="Input placeholder"/>
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Enquiry For <span class="text-danger">*</span></label>
                                        <input type="text" id="enquiry_for" name="enquiry_for" v-model="model.enquiry_for" class="form-control" placeholder="Enquiry For"/>.
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address <span class="text-danger">*</span></label>
                                        <!--<input type="text" class="form-control" name="example-text-input" placeholder="Input placeholder" />-->
                                        <textarea id="address" name="address" v-model="model.address" class="form-control" rows="5"></textarea>
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Given Date <span class="text-danger">*</span></label>
                                        <input type="text" id="given_date" name="given_date" class="form-control" />
                                        <span class="text-danger error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <!--<a href="#" class="btn btn-link">Cancel</a>-->
                                <button type="button" onclick="leadsCreate.save()" class="btn btn-primary ms-auto">Save Lead</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-label">Status <span class="text-danger">*</span></div>
                                <div>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" id="status_in_progress" name="status" v-model="model.status" value="In Progress" />
                                        <span class="form-check-label">In Progress</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio"  id="status_not_interested" name="status" v-model="model.status" value="Not Interested"/>
                                        <span class="form-check-label">Not Interested</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio"  id="status_converted" name="status" v-model="model.status" value="Converted" />
                                        <span class="form-check-label">Converted</span>
                                    </label>                                    
                                </div>
                                <span class="text-danger error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-label">Type <span class="text-danger">*</span></div>
                                <div>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" id="type_in_progress" name="type" v-model="model.type" value="Hot" />
                                        <span class="form-check-label">In Progress</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio"  id="type_not_interested" name="type" v-model="model.type" value="Warm"/>
                                        <span class="form-check-label">Not Interested</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio"  id="type_converted" name="type" v-model="model.type" value="Cold" />
                                        <span class="form-check-label">Converted</span>
                                    </label>                                    
                                </div>
                                <span class="text-danger error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-label">Assigned User <span class="text-danger">*</span></div>
                                <div>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" id="type_in_progress" name="assigned_user" v-model="model.assigned_user" value="CRE" />
                                        <span class="form-check-label">CRE</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio"  id="type_not_interested" name="assigned_user" v-model="model.assigned_user" value="DSE"/>
                                        <span class="form-check-label">DSE</span>
                                    </label>                                                                     
                                </div>
                                <span class="text-danger error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
    </div>

</div>
@endsection