<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicController extends Controller {

    private $request;
    private $response;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->response['inputs'] = $this->request->input();

        view()->share('store_configs', [
            'name' => 'RKM Lumdung',
        ]);

        return true;
    }

}
