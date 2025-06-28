<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppGlobals;

class PublicController extends Controller {

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

    public function signin() {
        if (AppGlobals::has_cookie(AppGlobals::user_key)) {
            return redirect(url('/admin'));
        }

        return view('admin.signin.signin');
    }

    public function logout() {
        // Remove all session data
        $this->request->session()->flush();

        // Remove all cookiess
        $response = response()->json(['message' => 'All cookies and session data removed']);

        foreach ($this->request->cookies as $key => $cookie) {
            $response->headers->clearCookie($key);
        }

        return $response;
    }
}
