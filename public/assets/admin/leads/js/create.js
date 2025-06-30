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

var vueLeadsCreate = new Vue({
    el: "#lead_create_page",
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
            indx: '',
            id: '',
            name: '',
            email: '',
            phone: '',
            enquiry_for: '',
            type: 'Hot',
            status: 'In Progress',
            address: '',
            given_date: '',
            given_date2: '',
            user_id: '',
            assigned_user: 'CRE',
            create_date: '',
            update_date: '',
            create_date2: '',
            update_date2: '',
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
            window.open(base_url + `/admin/leads/${this.rows[indx].key}/update`);
        },
        profile() {
            profile.signin.authenticate();
        }
    },
    watch: {},
});

window.leadsCreate = {
    data: {
        title: 'Create Vendors'
    },
    init() {
        this.onStart();
    },
    onStart() {
        var self = leadsCreate;

        vueLeadsCreate.$data.model.id = key;
        vueLeadsCreate.$data.mode = mode;

        self.onLoad.init_menu();

        if (vueLeadsCreate.$data.mode == 'update')
            self.get_data();

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
        var self = leadsCreate;

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

        $('#given_date').datepicker({
            autoclose: true,
            format: "dd M yyyy",
        }).on('changeDate', (e) => {
            const formatted = moment(e.date).format('YYYY-MM-DD');
            vueLeadsCreate.$data.model.given_date = formatted;

            $('#given_date').css('border', '');
            $('#given_date').parent('div').find('.error').text('');
            //vueLeadsCreate.$data.model.given_date2 = e.date;
            //console.log(formatted);
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
        });
        $('#phone').on('input', function (e) {
            e.preventDefault();
            var input = document.getElementById('phone');

            $('#phone').css('border', '');
            $('#phone').parent('div').find('.error').text('');

            if (input.value.length > 0 && !numeric_preg.test(input.value)) {
                $("phone").css("border", "1px solid red");
                $("#phone")
                        .parent("div")
                        .find(".error")
                        .text("Invalid Character. Special Characters and Text not allowed!");
                input.value = input.value.replace(numeric_regx, "");
            }

            if (input.value.length > 10) {
                input.value = input.value.substr(0, 10);
                $('#phone').css('border', '1px solid red');
                $('#phone').parent('div').find('.error').text('Mobile Number cannot be more than 10 degits !');
            }
        });

        $('#email').on('blur', function (e) {
            e.preventDefault();
            var value = $(this).val();
            var input = document.getElementById('profile');

            $('#email').css('border', '');
            $('#email').parent('div').find('.error').text('');

            if (input.value.length > 0 && !email_preg.test(input.value)) {
                $('#email').css('border', '1px solid red');
                $('#email').parent('div').find('.error').text('Invalid Email. Please enter a valid email address');
            }

            vueLeadsCreate.$data.profile = value;
        });
        $('#email').on('input', function (e) {
            e.preventDefault();
            var input = document.getElementById('email');

            $('#email').css('border', '');
            $('#email').parent('div').find('.error').text('');

            if (input.value.length > 0 && !email_preg.test(input.value)) {
                $('#email').css('border', '1px solid red');
                $('#email').parent('div').find('.error').text('Invalid Email. Please enter a valid email address');
            }
        });

        $('#enquiry_for').on('input', function (e) {
            e.preventDefault();
            var input = document.getElementById('email');

            $('#enquiry_for').css('border', '');
            $('#enquiry_for').parent('div').find('.error').text('');
        });
        $('#address').on('input', function (e) {
            e.preventDefault();
            var input = document.getElementById('email');

            $('#address').css('border', '');
            $('#address').parent('div').find('.error').text('');
        });
    },
    validate() {
        var self = leadsCreate;
        var errors = [];

        var preg_name = /^[a-zA-Z ]+$/;
        var preg_numeric = /^[0-9]+$/;
        var preg_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let model = vueLeadsCreate.$data.model;

        // Name
        if (!model.name.trim()) {
            $('#name').css('border', '1px solid red').parent('div').find('.error').text('Please enter name!');
            errors.push('name');
        } else if (!preg_name.test(model.name)) {
            $('#name').css('border', '1px solid red').parent('div').find('.error').text('Name should only have alphabets and spaces!');
            errors.push('name');
        }

        // Email
        if (!model.email.trim()) {
            $('#email').css('border', '1px solid red').parent('div').find('.error').text('Please enter email!');
            errors.push('email');
        } else if (!preg_email.test(model.email)) {
            $('#email').css('border', '1px solid red').parent('div').find('.error').text('Invalid email format!');
            errors.push('email');
        }

        // Phone
        if (!model.phone.toString().trim()) {
            $('#phone').css('border', '1px solid red').parent('div').find('.error').text('Please enter phone!');
            errors.push('phone');
        } else if (!preg_numeric.test(model.phone)) {
            $('#phone').css('border', '1px solid red').parent('div').find('.error').text('Phone must be numbers only!');
            errors.push('phone');
        }
        if (model.phone.length > 0 && model.phone.length < 10) {
            $('#phone').css('border', '1px solid red').parent('div').find('.error').text('Phone must have 10 digits!');
            errors.push('phone');
        }

        // Address
        if (!model.address.trim()) {
            $('#address').css('border', '1px solid red').parent('div').find('.error').text('Please enter address!');
            errors.push('address');
        }

        // Enquiry For
        if (!model.enquiry_for.trim()) {
            $('#enquiry_for').css('border', '1px solid red').parent('div').find('.error').text('Please enter enquiry!');
            errors.push('enquiry_for');
        }

        // Given Date
        if (!model.given_date.trim()) {
            $('#given_date').css('border', '1px solid red').parent('div').find('.error').text('Please select date!');
            errors.push('given_date');
        }

        // Status
        if (!model.status.trim()) {
            $('#status').css('border', '1px solid red').parent('div').find('.error').text('Please select status!');
            errors.push('status');
        }

        // Type
        if (!model.type.trim()) {
            $('#type').css('border', '1px solid red').parent('div').find('.error').text('Please select type!');
            errors.push('type');
        }

        console.log(errors);
        return errors.length === 0;
    },
    save() {
        var self = leadsCreate;
        let url = `/api/v1/admin/leads/create`;
        let action = 'leads/create';
        $('.loader').show();

        if (vueLeadsCreate.$data.mode == 'update') {
            url = `/api/v1/admin/leads/${vueLeadsCreate.$data.model.id}/update`;
            action = "leads/update";
        }

        let data = {};
        data.action = action;

        $.each(vueLeadsCreate.$data.model, (key, val) => {
            data[key] = vueLeadsCreate.$data.model[key];
        });

        data.mode = vueLeadsCreate.$data.mode;
        data.image = vueLeadsCreate.$data.image;

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
                        vueLeadsCreate.$data.mode = {
                            indx: '',
                            id: '',
                            name: '',
                            email: '',
                            phone: '',
                            enquiry_for: '',
                            type: 'Hot',
                            status: 'In Progress',
                            address: '',
                            given_date: '',
                            given_date2: '',
                            user_id: '',
                            assigned_user: 'CRE',
                            create_date: '',
                            update_date: '',
                            create_date2: '',
                            update_date2: '',
                        };

                        if (mode == 'save') {
                            $('#image_div').css('background', `url()`);
                            alert('Lead Created!');
                            window.location.reload();
                        } else {
                            alert('Lead Updated!');
                            window.location.reload();
                            //window.open(base_url + `/admin/users`);
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
        var self = leadsCreate;

        $.ajax({
            url: base_url + `/api/v1/admin/leads/${vueLeadsCreate.$data.model.id}`,
            type: 'POST',
            beforeSend: function (xhr) {
                globals.loader.add('leads/view');
            },
            data: {
                action: 'leads/view',
                //------------------------------
                key: vueLeadsCreate.$data.key,
            },
            dataType: 'json',
            success: function (resp, textStatus, jqXHR) {
                if (resp['msg'] == 'success') {
                    vueLeadsCreate.$data.rows = resp.data;

                    $.each(vueLeadsCreate.$data.model, (key, val) => {
                        vueLeadsCreate.$data.model[key] = resp.data[key];
                    });

                    vueLeadsCreate.$data.model.given_date = resp.data.given_date;
                    vueLeadsCreate.$data.model.given_date2 = resp.data.given_date2;
                    $('#given_date').datepicker('setDate', vueLeadsCreate.$data.model.given_date2);

                    setTimeout(function () {
                        globals.loader.remove('leads/view');
                    }, 0.5 * 1000);
                } else {
                    globals.loader.remove('leads/view');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                globals.loader.remove('leads/view');
                //toastr.error("Ups! Something went wrong.");
            },
        });
    },
    reset() {
        var self = leadsCreate;
        vueLeadsCreate.$data.search = '';
        vueLeadsCreate.$data.page = 0;
        vueLeadsCreate.$data.results_per_page = 10;

        $.each(vueLeadsCreate.$data.model, (key, val) => {
            vueLeadsCreate.$data.model[key] = '';
        });

        self.get_data();
    },
    actions() {
        switch (vueLeadsCreate.$data.action) {
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
        let self = leadsCreate;

        if (vueLeadsCreate.$data.leadsCreate_selected.length == 0) {
            alert('Please select at least one user');
            return false;
        }

        if (vueLeadsCreate.$data.action.length > 0) {
            $.ajax({
                url: base_url + `/api/v1/admin/leads/bulk/action`,
                type: 'POST',
                beforeSend: function (xhr) {
                    globals.loader.show();
                },
                data: {
                    action: 'leads/bulk/action',
                    keys: vueLeadsCreate.$data.leadsCreate_selected,
                    type: vueLeadsCreate.$data.action,
                },
                dataType: 'json',
                success: function (resp, textStatus, jqXHR) {
                    if (resp.msg == 'success') {
                        vueLeadsCreate.$data.leadsCreate_selected = [];
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
        var self = leadsCreate;
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
            //vueLeadsCreate.$data.image = file.name;
            vueLeadsCreate.$data.image = data;
            console.log([data, vueLeadsCreate.$data]);
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

