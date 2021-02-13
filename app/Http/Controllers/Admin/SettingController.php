<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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

        $settings = [];

        $dbSettings = Setting::get();

        foreach ($dbSettings as $db){

            $settings[$db['name']] = $db['content'];
        }

        return view('admin.settings.index', ['settings' => $settings]);

    }

    public function save(\Illuminate\Support\Facades\Request $request)
    {


    }

}
