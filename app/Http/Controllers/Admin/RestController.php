<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UsersService;
use App\Services\LeadsService;

class RestController extends Controller {

    private $request;
    private $response;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->response[ 'inputs' ] = $this->request->input();

        view()->share('store_configs', [
            'name' => 'RKM Lumdung',
        ]);

        return true;
    }

    public function api_signin() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'signin')) {
            $inputs = $this->request->input();
            return response()->json(UsersService::call()->signin($inputs));
        }
    }

    public function api_users_manage() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'users/manage')) {
            $inputs = $this->request->input();
            return response()->json(UsersService::call()->search($inputs));
        }
    }

    public function api_users_create() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'users/create')) {
            $inputs = $this->request->input();
            return response()->json(UsersService::call()->create($inputs));
        }
    }

    public function api_users_update() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'users/update')) {
            $inputs = $this->request->input();
            return response()->json(UsersService::call()->update($inputs));
        }
    }

    public function api_users_view() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'users/view')) {
            $inputs = $this->request->input();
            return response()->json(UsersService::call()->view($inputs));
        }
    }

    public function api_users_delete() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'users/delete')) {
            $inputs = $this->request->input();
            return response()->json(UsersService::call()->delete($inputs));
        }
    }

    public function api_leads_manage() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'leads/manage')) {
            $inputs = $this->request->input();
            return response()->json(LeadsService::call()->search($inputs));
        }
    }

    public function api_leads_create() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'leads/create')) {
            $inputs = $this->request->input();
            return response()->json(LeadsService::call()->create($inputs));
        }
    }

    public function api_leads_update() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'leads/update')) {
            $inputs = $this->request->input();
            return response()->json(LeadsService::call()->update($inputs));
        }
    }

    public function api_leads_view() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'leads/view')) {
            $inputs = $this->request->input();
            return response()->json(LeadsService::call()->view($inputs));
        }
    }

    public function api_leads_delete() {
        if (($this->request->input('action') !== null) && ($this->request->input('action') == 'leads/delete')) {
            $inputs = $this->request->input();
            return response()->json(LeadsService::call()->delete($inputs));
        }
    }
}
