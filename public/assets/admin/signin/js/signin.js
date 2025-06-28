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

console.log('admin.signin');

var vueAdminSignin = new Vue({
    el: "#admin_signin_page",
    data: {
        mode: 'save',
        rows: [],
        //---pagination---
        results_per_page: 10,
        page: 0,
        pages: 0,
        count: 0,
        pagination: [],
        //--------
        username: '',
        password: '',
        remember_me: false,
        //--------
        selected: [],
        active_tab: 'all',
        show_password: false,
        loader: false,
    },
    methods: {
        update(indx) {
            window.open(base_url + `/admin/admin-users/${this.rows[indx].key}/update`);
        },
        profile() {
            profile.signin.authenticate();
        }
    },
    watch: {},
});

window.adminSignin = {
    data: {
        title: 'Create Vendors'
    },
    init() {
        this.onStart();
    },
    onStart() {
        var self = adminSignin;

        self.onLoad.init_menu();
        globals.loader.remove(null);

        self.listeners();
    },
    onLoad: {
        init_menu() {
            $('#li_admin_users .dropdown-toggle').addClass('show');
            $('#li_admin_users .dropdown-menu').addClass('show');
        }
    },
    listeners() {
        var self = adminSignin;
        var alpha_numeric_preg = /^[A-Za-z0-9 ]+$/;
        var alpha_numeric_regx = /[^A-Za-z0-9 ]/g;
        var numeric_preg = /^[0-9]+$/;
        var numeric_regx = /[^0-9]/g;
        var alpha_preg = /^[A-Za-z ]+$/;
        var alpha_regx = /[^A-Za-z ]/g;
        var description_preg = /^[A-Za-z0-9,. ]+$/;
        var description_regx = /[^A-Za-z0-9,. ]/g;
        var email_preg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        $('#search').on('keyup', (e) => {
            e.preventDefault();

            if (e.keyCode == 13) {
                self.get_data();
            }
        });

        $('#username').on('keyup', function (e) {
            e.preventDefault();
            var preg = /^[A-Za-z.'",&#$\-_0-9\(\)\[\]% ]+$/;
            var value = $(this).val();
            var input = document.getElementById('username');

            $('#username').css('border', '');
            $('#username').parent('div').find('.error').text('');

            vueAdminSignin.$data.username = input.value;
        });
        $('#password').on('keyup', function (e) {
            e.preventDefault();
            var preg = /^[A-Za-z.'",&#$\-_0-9\(\)\[\]% ]+$/;
            var value = $(this).val();
            var input = document.getElementById('password');

            $('#password').css('border', '');
            $('#password').parent('div').find('.error').text('');

            vueAdminSignin.$data.password = input.value;
        });
    },
    validate() {
        var self = adminSignin;
        var errors = [];
        var preg_name = /^[a-zA-Z ]+$/;
        var preg_numeric = /^[0-9]+$/;
        var alpha_numeric = /^[a-zA-Z0-9]+$/;


        if (vueAdminSignin.$data.username.length == 0) {
            $('#username').css('border', '1px solid red');
            $('#username').parent('div').find('.error').text('Please enter a username!');
            errors.push('username');
        }

        if (vueAdminSignin.$data.password.length == 0) {
            $('#password').css('border', '1px solid red');
            $('#password').parent('div').find('.error').text('Please enter password!');
            errors.push('password');
        }

        console.log(errors);
        return (errors.length == 0) ? true : false;
    },
    save() {
        var self = adminSignin;
        let action = 'signin';

        if (self.validate()) {
            $.ajax({
                url: base_url + `/api/v1/admin/signin`,
                type: "POST",
                beforeSend: function (xhr) {
                    globals.loader.add(action);
                    vueAdminSignin.$data.loader = true;
                },
                data: {
                    action: action,
                    username: vueAdminSignin.$data.username,
                    password: vueAdminSignin.$data.password,
                    remember_me: vueAdminSignin.$data.remember_me,
                },
                dataType: "json",
                success: function (resp, textStatus, jqXHR) {
                    if (resp['msg'] == 'success') {
                        globals.cookies.set('user_key', resp.data.key);
                        globals.cookies.set('user_name', resp.data.name);
                        globals.cookies.set('user_username', resp.data.username);

                        globals.loader.remove(action);
                        vueAdminSignin.$data.loader = false;

                        globals.goto(`/admin/dashboard`);
                    } else {
                        globals.loader.remove(action);
                        vueAdminSignin.$data.loader = false;
//                        alert('User Name Already Exist!');
                        $('#username').parent('div').find('.error').text('Username Already Exist');
                    }
                }
            });
        } else {
            globals.loader.remove(action);
        }
    },
};


