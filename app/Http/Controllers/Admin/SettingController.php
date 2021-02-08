<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  SettingController extends Controller
{


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return view('admin.settings.index');

    }

    public function save(\Illuminate\Support\Facades\Request $request)
    {


    }

}
