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

console.log('leads.manage');

var vueLeads = new Vue({
    el: "#leads_page",
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
        type: '',
        status: '',
        assigned_user: '',
        date_range: '',
        selected_key: "",
        selected_row: [],
    },
    methods: {
        update(indx) {
            window.open(base_url + `/admin/leads/${this.rows[indx].key}/update`, "_blank", );
        },
        view(indx) {
            window.open(SITE_URL + `/admin/leads/${this.rows[indx].key}/update`, "_blank", );
        },
        confirm_delete(indx) {
            let row = this.rows[indx];

            this.selected_row = row;
            this.selected_key = row.key;

            $('#mdl_delete').modal('show');
        },
    },
    watch: {
        'search': (value) => {
            console.log(value);
            vueLeads.$data.page = 1;
            leads.get_data();
        },
        'status': (value) => {
            console.log(value);
            vueLeads.$data.page = 1;
            leads.get_data();
        },
        'type': (value) => {
            console.log(value);
            vueLeads.$data.page = 1;
            leads.get_data();
        },
        'assigned_user': (value) => {
            console.log(value);
            vueLeads.$data.page = 1;
            leads.get_data();
        },
    },
});

window.leads = {
    data: {
        title: 'Create Vendors'
    },
    init() {
        this.onStart();
    },
    onStart() {
        var self = leads;

        self.onLoad.init_menu();
        self.get_data();

        self.listeners();
    },
    onLoad: {
        init_menu() {
            $('#li_leads .dropdown-toggle').addClass('show');
            $('#li_leads .dropdown-menu').addClass('show');
        }
    },
    listeners() {
        var self = leads;

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

        $('input[name="chk_select_all"]').on('change', (e) => {
            if ($('input[name="chk_select_all"]').prop('checked')) {
                $.each(vueLeads.$data.products.rows, (k, d) => {
                    vueLeads.$data.products.selected.push(d.key);
                });
            } else {
                vueLeads.$data.products.selected = [];
            }
        });
        $(document).on('change', '.chk', (e) => {
            let chk = $('.chk');
            let count = chk.length;
            let count2 = 0;
            console.log(chk.length, vueLeads.$data.products.selected);

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
                $.each(vueLeads.$data.products_in_category.rows, (k, d) => {
                    vueLeads.$data.products_in_category.selected.push(d.key);
                });
            } else {
                vueLeads.$data.products_in_category.selected = [];
            }
        });
        $(document).on('change', '.chk_cp', (e) => {
            let chk = $('.chk_cp');
            let count = chk.length;
            let count2 = 0;
            console.log(chk.length, vueLeads.$data.products_in_category.selected);

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
            vueLeads.$data.selected_key = '';
            vueLeads.$data.selected_row = '';
        });
    },
    get_data() {
        var self = leads;

        $.ajax({
            url: base_url + `/api/v1/admin/leads`,
            type: 'POST',
            beforeSend: function (xhr) {
                globals.loader.show();
            },
            data: {
                action: 'leads/manage',
                results_per_page: vueLeads.$data.results_per_page,
                page: vueLeads.$data.page,
                //------------------------------
                search: vueLeads.$data.search,
                type: vueLeads.$data.type,
                status: vueLeads.$data.status,
                date_range: vueLeads.$data.date_range,
                assigned_user: vueLeads.$data.assigned_user,
                //type: '3',
                sort_by: vueLeads.$data.sort_by,
                sort_order: vueLeads.$data.sort_order,
            },
            dataType: 'json',
            success: function (resp, textStatus, jqXHR) {
                if (resp['msg'] == 'success') {
                    vueLeads.$data.rows = resp.data;

                    vueLeads.$data.count = parseInt(resp.pagination.count);
                    vueLeads.$data.page = parseInt(resp.pagination.page);
                    vueLeads.$data.pages = parseInt(resp.pagination.pages);

                    setTimeout(function () {
                        self.pagination.init();
                        //self.treegrid.init();

                        globals.loader.hide();
                    }, 0.5 * 1000);
                } else {
                    globals.loader.hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                globals.loader.hide();
                //toastr.error("Ups! Something went wrong.");
            },
        });
    },
    pagination: {
        init() {
            var self = leads;

            vueLeads.$data.pagination = $('.pagination').pagination({
                total: vueLeads.$data.count,
                pageSize: vueLeads.$data.results_per_page,
                pageNumber: vueLeads.$data.page,
                pageList: [10, 20, 50, 100],
                onSelectPage: (pageNumber, event) => {
                    vueLeads.$data.page = pageNumber;
                    self.get_data();

                    var pathname = window.location.pathname;
                    window.history.pushState({"html": "", "pageTitle": "page - " + pageNumber}, "", pathname + "?page=" + pageNumber);

                    return false;
                },
                onChangePageSize: (pageSize) => {
                    vueLeads.$data.page = 0;
                    vueLeads.$data.results_per_page = pageSize;
                    leads.get_data();

                    return false;
                }
            });
        }
    },
    reset() {
        var self = leads;

        vueLeads.$data.search = '';
        vueLeads.$data.wallet_address = '';
        vueLeads.$data.key = '';
        vueLeads.$data.name = '';
        vueLeads.$data.email = '';
        vueLeads.$data.phone = '';
        vueLeads.$data.date = '';
        vueLeads.$data.page = 0;
        vueLeads.$data.results_per_page = 10;

        self.get_data();
    },
    bulk_action() {
        let self = leads;

        if (vueLeads.$data.leads_selected.length == 0) {
            alert('Please select at least one user');
            return false;
        }

        if (vueLeads.$data.action.length > 0) {
            $.ajax({
                url: base_url + `/api/v1/admin/leads/bulk/action`,
                type: 'POST',
                beforeSend: function (xhr) {
                    globals.loader.show();
                },
                data: {
                    action: 'leads/bulk/action',
                    keys: vueLeads.$data.leads_selected,
                    type: vueLeads.$data.action,
                },
                dataType: 'json',
                success: function (resp, textStatus, jqXHR) {
                    if (resp.msg == 'success') {
                        vueLeads.$data.leads_selected = [];
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
        var self = leads;
        let url = `/api/v1/admin/leads/delete`;//${vueLeads.$data.key}
        let action = 'leads/delete';

        $.ajax({
            url: base_url + url,
            type: "POST",
            beforeSend: function (xhr) {
                globals.loader.show();
            },
            data: {
                action: action,
                key: vueLeads.$data.selected_key,
            },
            dataType: "json",
            success: function (resp, textStatus, jqXHR) {
                if (resp['msg'] == 'success') {
                    alert('Campaigns deleted!');
                    vueLeads.$data.selected_key = '';
                    vueLeads.$data.selected_row = [];
                    $('#mdl_delete').modal('hide');

                    setTimeout(function () {
                        self.get_data();
                        // globals.goto('/leads/create');
                    }, 0.5 * 1000);

                    globals.loader.hide();
                } else {
                    globals.loader.hide();
                }
            }
        });
    },
};












