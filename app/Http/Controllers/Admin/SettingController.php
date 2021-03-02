<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function save(Request $request)
    {
        $data = $request->only([
            'title', 'subtitle', 'email', 'bgcolor', 'textcolor'
        ]);

        $validator = $this->validator($data);

        if($validator->fails()){

            return redirect()->route('settings')->withErrors($validator);
        }


        foreach ($data as $item => $value){

            Setting::where('name', $item)->update(['content' => $value]);
        }


        return redirect()->route('settings');

    }

    protected function validator($data){

        return Validator::make($data, [

            'title' => ['required', 'string', 'max:100'],
            'subtitle' => ['required', 'string', 'max:100'],
            'email' => ['string', 'email'],
            'bgcolor' => ['string', 'regex:/#[A-Z0-9]{6}/i'],
            'textcolor' => ['string', 'regex:/#[A-Z0-9]{6}/i']
        ]);
    }

}
