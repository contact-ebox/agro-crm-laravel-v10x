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

console.log('users.manage');

var vueUsers = new Vue({
    el: "#users_page",
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
        search: '',
        status: '',
        selected_key: "",
        selected_row: [],
    },
    methods: {
        update(indx) {
            window.open(base_url + `/admin/users/${this.rows[indx].key}/update`, "_blank", );
        },
        view(indx) {
            window.open(SITE_URL + `/admin/users/${this.rows[indx].key}/update`, "_blank", );
        },
        confirm_delete(indx) {
            let row = this.rows[indx];

            this.selected_row = row;
            this.selected_key = row.key;

            $('#mdl_delete').modal('show');
        },
    },
    watch: {},
});

window.users = {
    data: {
        title: 'Create Vendors'
    },
    init() {
        this.onStart();
    },
    onStart() {
        var self = users;

        self.onLoad.init_menu();
        self.get_data();

        self.listeners();
    },
    onLoad: {
        init_menu() {
            $('#li_users .dropdown-toggle').addClass('show');
            $('#li_users .dropdown-menu').addClass('show');
        }
    },
    listeners() {
        var self = users;

        var alpha_numeric_preg = /^[A-Za-z0-9 ]+$/;
        var alpha_numeric_regx = /[^A-Za-z0-9 ]/g;
        var numeric_preg = /^[0-9]+$/;
        var numeric_regx = /[^0-9]/g;
        var alpha_preg = /^[A-Za-z ]+$/;
        var alpha_regx = /[^A-Za-z ]/g;
        var description_preg = /^[A-Za-z0-9,. ]+$/;
        var description_regx = /[^A-Za-z0-9,. ]/g;

        $('#search').on('keyup', (e) => {
            e.preventDefault();

            if (e.keyCode == 13) {
                self.get_data();
            }
        });

        $('#mdl_listed_products').on('hide.bs.modal', (e) => {
            vueUsers.$data.products_in_category.rows = [];
            vueUsers.$data.products_in_category.key = '';
            vueUsers.$data.products.selected = [];
            console.log(vueUsers.$data.products_in_category.rows);
        });
        $('#btn_show_products').on('click', (e) => {
            $('#tbl_products_in_category').hide();
            $('#action_products_in_category').hide();

            $('#tbl_products').show();
            $('#action_products').show();

            self.products.get_data();
        });
        $('#btn_hide_products').on('click', (e) => {
            $('#tbl_products_in_category').show();
            $('#action_products_in_category').show();

            $('#tbl_products').hide();
            $('#action_products').hide();
        });

        $('input[name="chk_select_all"]').on('change', (e) => {
            if ($('input[name="chk_select_all"]').prop('checked')) {
                $.each(vueUsers.$data.products.rows, (k, d) => {
                    vueUsers.$data.products.selected.push(d.key);
                });
            } else {
                vueUsers.$data.products.selected = [];
            }
        });
        $(document).on('change', '.chk', (e) => {
            let chk = $('.chk');
            let count = chk.length;
            let count2 = 0;
            console.log(chk.length, vueUsers.$data.products.selected);

            $.each(chk, (k, e) => {
                if ($(e).prop('checked'))
                    count2++;
            });

            if (count == count2) {
                $('input[name="chk_select_all"]').prop('checked', true);
            } else {
                $('input[name="chk_select_all"]').prop('checked', false);
            }
        });

        $('input[name="chk_cp_select_all"]').on('change', (e) => {
            if ($('input[name="chk_cp_select_all"]').prop('checked')) {
                $.each(vueUsers.$data.products_in_category.rows, (k, d) => {
                    vueUsers.$data.products_in_category.selected.push(d.key);
                });
            } else {
                vueUsers.$data.products_in_category.selected = [];
            }
        });
        $(document).on('change', '.chk_cp', (e) => {
            let chk = $('.chk_cp');
            let count = chk.length;
            let count2 = 0;
            console.log(chk.length, vueUsers.$data.products_in_category.selected);

            $.each(chk, (k, e) => {
                if ($(e).prop('checked'))
                    count2++;
            });

            if (count == count2) {
                $('input[name="chk_cp_select_all"]').prop('checked', true);
            } else {
                $('input[name="chk_cp_select_all"]').prop('checked', false);
            }
        });

        $('#mdl_delete').on('hide.bs.modal', (e) => {
            vueUsers.$data.selected_key = '';
            vueUsers.$data.selected_row = '';
        });
    },
    get_data() {
        var self = users;

        $.ajax({
            url: base_url + `/api/v1/admin/users`,
            type: 'POST',
            beforeSend: function (xhr) {
                $('#loading').show();
            },
            data: {
                action: 'users/manage',
                results_per_page: vueUsers.$data.results_per_page,
                page: vueUsers.$data.page,
                //------------------------------
                search: vueUsers.$data.search,
                status: vueUsers.$data.status,
                //type: '3',
                sort_by: vueUsers.$data.sort_by,
                sort_order: vueUsers.$data.sort_order,
            },
            dataType: 'json',
            success: function (resp, textStatus, jqXHR) {
                if (resp['msg'] == 'success') {
                    vueUsers.$data.rows = resp.data;

                    vueUsers.$data.count = resp.pagination.count;
                    vueUsers.$data.page = resp.pagination.page;
                    vueUsers.$data.pages = resp.pagination.pages;

                    setTimeout(function () {
                        self.pagination.init();
                        //self.treegrid.init();

                        globals.loader.hide();
                    }, 0.5 * 1000);
                } else {
                    $('#loading').hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loading').hide();
                //toastr.error("Ups! Something went wrong.");
            },
        });
    },
    pagination: {
        init() {
            var self = users;

            vueUsers.$data.pagination = $('.pagination').pagination({
                total: vueUsers.$data.count,
                pageSize: vueUsers.$data.results_per_page,
                pageNumber: vueUsers.$data.page,
                pageList: [10, 20, 50, 100],
                onSelectPage: (pageNumber, event) => {
                    vueUsers.$data.page = pageNumber;
                    self.get_data();

                    var pathname = window.location.pathname;
                    window.history.pushState({"html": "", "pageTitle": "page - " + pageNumber}, "", pathname + "?page=" + pageNumber);

                    return false;
                },
                onChangePageSize: (pageSize) => {
                    vueUsers.$data.page = 0;
                    vueUsers.$data.results_per_page = pageSize;
                    users.get_data();

                    return false;
                }
            });
        }
    },
    reset() {
        var self = users;

        vueUsers.$data.search = '';
        vueUsers.$data.wallet_address = '';
        vueUsers.$data.key = '';
        vueUsers.$data.name = '';
        vueUsers.$data.email = '';
        vueUsers.$data.phone = '';
        vueUsers.$data.date = '';
        vueUsers.$data.page = 0;
        vueUsers.$data.results_per_page = 10;

        self.get_data();
    },
    bulk_action() {
        let self = users;

        if (vueUsers.$data.users_selected.length == 0) {
            alert('Please select at least one user');
            return false;
        }

        if (vueUsers.$data.action.length > 0) {
            $.ajax({
                url: base_url + `/api/v1/admin/users/bulk/action`,
                type: 'POST',
                beforeSend: function (xhr) {
                    globals.loader.show();
                },
                data: {
                    action: 'users/bulk/action',
                    keys: vueUsers.$data.users_selected,
                    type: vueUsers.$data.action,
                },
                dataType: 'json',
                success: function (resp, textStatus, jqXHR) {
                    if (resp.msg == 'success') {
                        vueUsers.$data.users_selected = [];
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
    delete() {
        var self = users;
        let url = `/api/v1/admin/users/delete`;//${vueUsers.$data.key}
        let action = 'users/delete';

        $.ajax({
            url: base_url + url,
            type: "POST",
            beforeSend: function (xhr) {
                globals.loader.show();
            },
            data: {
                action: action,
                key: vueUsers.$data.selected_key,
            },
            dataType: "json",
            success: function (resp, textStatus, jqXHR) {
                if (resp['msg'] == 'success') {
                    alert('Campaigns deleted!');
                    vueUsers.$data.selected_key = '';
                    vueUsers.$data.selected_row = [];
                    $('#mdl_delete').modal('hide');

                    setTimeout(function () {
                        self.get_data();
                        // globals.goto('/users/create');
                    }, 0.5 * 1000);

                    globals.loader.hide();
                } else {
                    globals.loader.hide();
                }
            }
        });
    },
};
