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
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>Sign in | {{env('APP_NAME')}} </title>

        <!--font-awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- CSS files -->        
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler.min.css" rel="stylesheet"/>
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler-flags.min.css" rel="stylesheet"/>
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler-payments.min.css" rel="stylesheet"/>
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler-vendors.min.css" rel="stylesheet"/>
        <link href="{{url('/')}}/assets/admin/layouts/css/demo.min.css" rel="stylesheet"/>

        <script type="text/javascript">
            const  base_url = '{{env("APP_URL")}}';
            const  SITE_URL = '{{env("SITE_URL")}}';
        </script>
    </head>
    <body  class=" border-top-wide border-primary d-flex flex-column">
        <div class="page page-center" id="admin_signin_page">
            <div class="container-tight py-4">
                <div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
                </div>
                <form class="card card-md" action="." method="get" autocomplete="off">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login to your account</h2>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" id="username" name="username" v-model="username" class="form-control" placeholder="Enter username" autocomplete="off" />
                            <span class="text-danger error"></span>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                Password
                                <span class="form-label-description d-none">
                                    <a href="./forgot-password.html">I forgot password</a>
                                </span>
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" id="password" v-model="password" v-if="!show_password" class="form-control"  placeholder="Enter password"  autocomplete="off" />
                                <input type="text" id="password" v-model="password" v-if="show_password" class="form-control"  placeholder="Enter password"  autocomplete="off" />
                                <span class="input-group-text">
                                    <a v-if="!show_password" v-on:click="show_password=!show_password" class="link-secondary" style="cursor: pointer;">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" />
                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                        </svg>
                                    </a>
                                    <a v-if="show_password" v-on:click="show_password=!show_password" class="link-secondary" style="cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="3" y1="3" x2="21" y2="21"></line><path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
                                        <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 
                                              1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"></path>
                                        </svg>
                                    </a>
                                </span>                                
                            </div>
                            <span class="text-danger error"></span>
                        </div>
                        <div class="mb-2">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input"/>
                                <span class="form-check-label">Remember me on this device</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="button" class="btn btn-primary w-100" onclick="adminSignin.save();" v-bind:disabled="loader">
                                Sign in &nbsp;&nbsp;
                                <i v-if="loader" class="fa-solid fa-arrows-rotate fa-spin"></i>
                            </button>
                        </div>
                    </div>                   
                </form>

                <div class="text-center text-muted mt-3">
                    Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
                </div>
            </div>
        </div>

        <script src="{{url('/')}}/plugins/jquery/jquery-2.2.4.min.js" type="text/javascript"></script>
        <!-- Tabler Core -->
        <script src="{{url('/')}}/assets/admin/layouts/js/tabler.min.js" defer></script>
        <script src="{{url('/')}}/assets/admin/layouts/js/demo.min.js" defer></script>

        <script src="{{url('/')}}/plugins/vue/vue.min.js" type="text/javascript"></script>
        <script src="{{url('/')}}/assets/globals/js/globals.js" type="text/javascript"></script>
        <script src="{{url('/')}}/assets/admin/signin/js/signin.js" type="text/javascript"></script>

        <script type="text/javascript">globals.modules.attach(adminSignin);</script>
    </body>
</html>
