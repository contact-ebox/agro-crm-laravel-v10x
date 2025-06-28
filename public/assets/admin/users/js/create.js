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




console.log('users.create');

var vueUsersCreate = new Vue({
    el: "#users_create_page",
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
        model: {
            indx: null, // Initialize to null
            key: '',
            fname: '',
            mname: '',
            lname: '',
            email: '',
            phone: null,
            mobile: null,
            gender: '',
            login_name: '',
            role: '',
            verified: '',
            email_vrified: '',
            email_token: '',
            image: {
                name: '',
                type: '',
                data: '',
                ext: '',
            },
            status: 1, // Default value
            status_text: '', // Default value
            create_date: null, // Initialize to null
            update_date: null, // Initialize to null          
            create_date2: null, // Initialize to null
            update_date2: null, // Initialize to null       
            password: '',
            remarks: '',
            otp: null,
            permissions: {
                coupons: {
                    module: true,
                    can_view: true,
                    can_create: false,
                    can_update: false,
                    can_delete: false,
                },
                users: {
                    module: true,
                    can_view: true,
                    can_create: false,
                    can_update: false,
                    can_delete: false,
                }
            },
        },
        image: {
            name: '',
            type: '',
            data: '',
            ext: '',
        },
        //--------
        selected: [],
        active_tab: 'all',
        show_password: false,
    },
    methods: {
        update(indx) {
            window.open(base_url + `/admin/users/${this.rows[indx].key}/update`);
        },
        profile() {
            profile.signin.authenticate();
        }
    },
    watch: {},
});

window.usersCreate = {
    data: {
        title: 'Create Vendors'
    },
    init() {
        this.onStart();
    },
    onStart() {
        var self = usersCreate;

        vueUsersCreate.$data.key = key;
        vueUsersCreate.$data.mode = mode;

        self.onLoad.init_menu();

        if (vueUsersCreate.$data.mode == 'update')
            self.get_data();

        if (localStorage.getItem('coin') != null) {
            $.each(JSON.parse(localStorage.getItem('coin')), (dx, ob) => {
                vueUsersCreate.$data[dx] = ob;

                if (dx == 'image')
                    $('#coin_image').attr('src', ob.data);
            });
        }

        globals.loader.remove(null);

        self.listeners();
    },
    onLoad: {
        init_menu() {
            $('#li_users .dropdown-toggle').addClass('show');
            $('#li_users .dropdown-menu').addClass('show');
        }
    },
    listeners() {
        var self = usersCreate;
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

        $('#name').on('keyup', function (e) {
            e.preventDefault();
            var preg = /^[A-Za-z.'",&#$\-_0-9\(\)\[\]% ]+$/;
            var value = $(this).val();
            var input = document.getElementById('name');

            $('#name').css('border', '');
            $('#name').parent('div').find('.error').text('');

            if (input.value.length > 0 && !preg.test(input.value)) {
                $('#name').css('border', '1px solid red');
                $('#name').parent('div').find('.error').text('Invalid charecter. Special characters and numbers not allowed!');
                return false;
            }

            vueUsersCreate.$data.name = input.value;
            vueUsersCreate.$data.slug = self.slugify(input.value);
        });

        $('#number').on('blur', function (e) {
            e.preventDefault();
            var value = $(this).val();
            var input = document.getElementById('number');

            $('#number').css('border', '');
            $('#number').parent('div').find('.error').text('');

            if (input.value.length > 0 && input.value.length != 10) {
                $('#number').css('border', '1px solid red');
                $('#number').parent('div').find('.error').text('Mobile Number should be 10 digits !');
            }

            vueUsersCreate.$data.number = value;
        });
        $('#number').on('input', function (e) {
            e.preventDefault();
            var input = document.getElementById('number');

            $('#number').css('border', '');
            $('#number').parent('div').find('.error').text('');

            if (input.value.length > 0 && !numeric_preg.test(input.value)) {
                $("#number").css("border", "1px solid red");
                $("#number")
                        .parent("div")
                        .find(".error")
                        .text("Invalid Character. Special Characters and Text not allowed!");
                input.value = input.value.replace(numeric_regx, "");
            }

            if (input.value.length > 10) {
                input.value = input.value.substr(0, 10);
                $('#number').css('border', '1px solid red');
                $('#number').parent('div').find('.error').text('Mobile Number cannot be more than 10 degits !');
            }
        });

        $('#profile').on('blur', function (e) {
            e.preventDefault();
            var value = $(this).val();
            var input = document.getElementById('profile');

            $('#profile').css('border', '');
            $('#profile').parent('div').find('.error').text('');

            if (input.value.length > 0 && !email_preg.test(input.value)) {
                $('#profile').css('border', '1px solid red');
                $('#profile').parent('div').find('.error').text('Invalid Email. Please enter a valid email address');
            }

            vueUsersCreate.$data.profile = value;
        });
        $('#profile').on('input', function (e) {
            e.preventDefault();
            var input = document.getElementById('profile');

            $('#profile').css('border', '');
            $('#profile').parent('div').find('.error').text('');

            if (input.value.length > 0 && !email_preg.test(input.value)) {
                $('#profile').css('border', '1px solid red');
                $('#profile').parent('div').find('.error').text('Invalid Email. Please enter a valid email address');
            }
        });
    },
    validate() {
        var self = usersCreate;
        var errors = [];
        var preg_name = /^[a-zA-Z ]+$/;
        var preg_numeric = /^[0-9]+$/;
        var alpha_numeric = /^[a-zA-Z0-9]+$/;

        if (vueUsersCreate.$data.model.fname.length == 0) {
            $('#name').css('border', '1px solid red');
            $('#name').parent('div').find('.error').text('Please enter name!');
            errors.push('name');
        }
        if (vueUsersCreate.$data.model.login_name.length == 0) {
            $('#login_name').css('border', '1px solid red');
            $('#login_name').parent('div').find('.error').text('Please enter a username!');
            errors.push('login_name');
        }
        if (vueUsersCreate.$data.mode == 'save' && vueUsersCreate.$data.model.password.length == 0) {
            $('#password').css('border', '1px solid red');
            $('#password').parent('div').find('.error').text('Please enter password!');
            errors.push('password');
        }

        console.log(errors);
        return (errors.length == 0) ? true : false;
    },
    save() {
        var self = usersCreate;
        let url = `/api/v1/admin/users/create`;
        let action = 'users/create';
        $('.loader').show();

        if (vueUsersCreate.$data.mode == 'update') {
            url = `/api/v1/admin/users/${vueUsersCreate.$data.key}/update`;
            action = "users/update";
        }

        let data = {};
        data.action = action;

        $.each(vueUsersCreate.$data.model, (key, val) => {
            data[key] = vueUsersCreate.$data.model[key];
        });

        data.mode = vueUsersCreate.$data.mode;
        data.image = vueUsersCreate.$data.image;

        if (self.validate()) {
            $.ajax({
                url: base_url + url,
                type: "POST",
                beforeSend: function (xhr) {
                    globals.loader.add(action);
                },
                data: data,
                dataType: "json",
                success: function (resp, textStatus, jqXHR) {
                    if (resp['msg'] == 'success') {
                        vueUsersCreate.$data.mode = '';
                        $.each(vueUsersCreate.$data.model, (key, val) => {
                            vueUsersCreate.$data.model[key] = '';
                        });
                        vueUsersCreate.$data.image = {
                            name: '',
                            type: '',
                            data: '',
                            ext: '',
                        };
                        if (mode == 'save') {
                            $('#image_div').css('background', `url()`);
                            alert('User Created!');
                            window.open(base_url + `/admin/users`);
                        } else {
                            alert('User Updated!');
                            window.location.reload();
                            window.open(base_url + `/admin/users`);
                            //globals.goto('/marketing/categories');
                        }

                        globals.loader.remove(action);
                    } else {
                        globals.loader.remove(action);
//                        alert('User Name Already Exist!');
                        $('#login_name').parent('div').find('.error').text('Username Already Exist');
                    }
                }
            });
        } else {
            globals.loader.remove(action);
        }
    },
    get_data() {
        var self = usersCreate;

        $.ajax({
            url: base_url + `/api/v1/admin/users/${vueUsersCreate.$data.key}`,
            type: 'POST',
            beforeSend: function (xhr) {
                globals.loader.add('users/view');
            },
            data: {
                action: 'users/view',
                //------------------------------
                key: vueUsersCreate.$data.key,
            },
            dataType: 'json',
            success: function (resp, textStatus, jqXHR) {
                if (resp['msg'] == 'success') {
                    vueUsersCreate.$data.rows = resp.data;

                    $.each(vueUsersCreate.$data.model, (key, val) => {
                        vueUsersCreate.$data.model[key] = resp.data[key];
                    });

                    vueUsersCreate.$data.model.password = '';
                    vueUsersCreate.$data.image = self.process_image_data(resp.data.image);

                    if (vueUsersCreate.$data.model.permissions == null) {
                        vueUsersCreate.$data.model.permissions = {
                            leads: {
                                module: true,
                                can_view: true,
                                can_create: false,
                                can_update: false,
                                can_delete: false,
                            },
                            admusers: {
                                module: true,
                                can_view: true,
                                can_create: false,
                                can_update: false,
                                can_delete: false,
                            }
                        };
                    }

                    //vueUsersCreate.$data.banner_text = resp.data.banner_text;

                    if (vueUsersCreate.$data.image.data != undefined) {
                        $('#coin_image').attr('src', `${base_url}/uploads/users/${vueUsersCreate.$data.image.data}`);
                    }

                    setTimeout(function () {
                        globals.loader.remove('users/view');
                    }, 0.5 * 1000);
                } else {
                    globals.loader.remove('users/view');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                globals.loader.remove('users/view');
                //toastr.error("Ups! Something went wrong.");
            },
        });
    },
    reset() {
        var self = usersCreate;
        vueUsersCreate.$data.search = '';
        vueUsersCreate.$data.page = 0;
        vueUsersCreate.$data.results_per_page = 10;

        $.each(vueUsersCreate.$data.model, (key, val) => {
            vueUsersCreate.$data.model[key] = '';
        });

        self.get_data();
    },
    actions() {
        switch (vueUsersCreate.$data.action) {
            case "A":
            {
                break;
            }
            case "I":
            {
                break;
            }
            default :
            {
                alert('Please select a action!');
                break;
            }
        }
    },
    bulk_action() {
        let self = usersCreate;

        if (vueUsersCreate.$data.usersCreate_selected.length == 0) {
            alert('Please select at least one user');
            return false;
        }

        if (vueUsersCreate.$data.action.length > 0) {
            $.ajax({
                url: base_url + `/api/v1/admin/users/bulk/action`,
                type: 'POST',
                beforeSend: function (xhr) {
                    globals.loader.show();
                },
                data: {
                    action: 'users/bulk/action',
                    keys: vueUsersCreate.$data.usersCreate_selected,
                    type: vueUsersCreate.$data.action,
                },
                dataType: 'json',
                success: function (resp, textStatus, jqXHR) {
                    if (resp.msg == 'success') {
                        vueUsersCreate.$data.usersCreate_selected = [];
                        alert('Data updated');
                        self.get_data();
                        globals.loader.hide();
                    } else {
                        globals.loader.hide();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    globals.loader.hide();
                }
            });
        } else {
            alert('Please select an action!');
            globals.loader.hide();
        }
    },
    slugify(str) {
        return String(str)
                .normalize('NFKD') // split accented characters into their base characters and diacritical marks
                .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
                .trim() // trim leading or trailing whitespace
                .toLowerCase() // convert to lowercase
                .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
                .replace(/\s+/g, '-') // replace spaces with hyphens
                .replace(/-+/g, '-'); // remove consecutive hyphens
    },
    /*--File upload--*/
    upload_file() {
        let input = document.getElementById('upload_image').click();
    },
    on_image_upload(event) {
        var self = usersCreate;
        let file = $(event)[0].files[0];
        let reader = new FileReader();
        let data = {};

        reader.onload = function (me) {
            //console.log(reader.result);
            data = {
                name: file.name,
                type: file.type,
                data: reader.result,
                ext: file.type,
            };
            //vueUsersCreate.$data.image = file.name;
            vueUsersCreate.$data.image = data;
            console.log([data, vueUsersCreate.$data]);
            // this.panData.panImg=reader.result ;
            $('#coin_image').attr('src', data.data);
        };

        reader.onerror = function (error) {
            console.log('Error: ', error);
            return reader.result;
        };

        reader.readAsDataURL(file);
    },
    /*--./File upload--*/
    process_image_data(params) {
        let temp = {};

        if (params != undefined) {
            temp = {
                key: params,
                name: params,
                data: params,
                ext: params,
                type: params,
            };
            console.log([params, temp]);
        }

        return temp;
    }
};