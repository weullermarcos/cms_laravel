<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function imageUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png'
        ]);

        //criando nome do arquivo
        $imageName = time() . '.' . $request->file->extension();

        //movendo arquivo
        $request->file->move(public_path('media/images'), $imageName);

        return [
            'location' => asset('media/images/' . $imageName)
        ];
    }
}
