<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //adicionando middleware para verificar se o usuário está logad
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recuperando todos os usuários - Fazendo paginação
        $pages = Page::paginate(10);


        //retornando usuários recuperados como parametro
        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //retorna a tela de cadastro de página
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'body'
        ]);

        $data['slug'] = Str::slug($data['title'], '-');

        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'body' => ['string'],
            'slug' => ['required', 'string', 'min:4', 'unique:pages'],
        ]);

        if($validator->fails()){

            return redirect()->route('pages.create')->withErrors($validator)->withInput();
        }

        $page = new Page();
        $page->title = $data['title'];
        $page->body = $data['body'];
        $page->slug = $data['slug'];
        $page->save();

        return redirect()->route('pages.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);

        if($page){

            return view('admin.pages.edit', ['page' => $page]);
        }

        return redirect()->route('pages.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        if($page){

            $data = $request->only([
                'title',
                'body'
            ]);

            if($page->title != $data['title']){

                $data['slug'] = Str::slug($data['title'], '-');
                $page->slug = $data['slug'];

                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string'],
                    'slug' => ['required', 'string', 'min:4', 'unique:pages'],
                ]);
            }
            else{

                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string'],
                ]);
            }

            if($validator->fails()){

                return redirect()->route('pages.edit', ['page' => $page])->withErrors($validator)->withInput();
            }

            $page->title = $data['title'];
            $page->body = $data['body'];
            $page->save();
        }

        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
