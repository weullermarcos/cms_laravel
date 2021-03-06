<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //adicionando middleware para verificar se o usuário está logad
        $this->middleware('can:edit-users'); //adicionando middlera para verificar se usuário tem permissão de administrador para ver as páginas
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recuperando todos os usuários - Fazendo paginação
        $users = User::paginate(10);

        //recuperando id do usuário logado
        $loggedId = Auth::id();

        //retornando usuários recuperados como parametro
        return view('admin.users.index', ['users' => $users, 'loggedId' => $loggedId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        if($validator->fails()){

            return redirect()->route('users.create')->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('users.index');

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

        $user = User::find($id);

        if($user){

            return view('admin.users.edit', ['user' => $user]);
        }

        return redirect()->route('users.index');

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

        $user = User::find($id);

        if($user){

            $data = $request->only([

                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            $validator = Validator::make([

                'name' => $data['name'],
                'email' => $data['email']

            ], [

                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:100']

            ]);

            //Alteração do nome
            $user->name = $data['name'];

            if($user->email != $data['email']){

                //verifica se o novo email já existe
                $hasEmail = User::where('email', $data['email'])->get();

                if(count($hasEmail) === 0){

                    //altera e-mail
                    $user->email = $data['email'];
                }
                else{

                    $validator->errors()->add('email', __('validation.unique', [

                        'attribute' => 'email'
                    ]));
                }
            }

            if(!empty($data['password'])){

                if(strlen($data['password']) >= 4){
                    if($data['password'] === $data['password_confirmation']){

                        $user->password = Hash::make($data['password']);
                    }
                    else{

                        $validator->errors()->add('password', __('validation.confirmed', [

                            'attribute' => 'password',
                        ]));
                    }
                }
                else{
                    $validator->errors()->add('password', __('validation.min.string', [

                        'attribute' => 'password',
                        'min' => 4
                    ]));
                }
            }

            //se houverem erros
            if(count($validator->errors())){

                return redirect()->route('users.edit', ['user' => $id])->withErrors($validator);
            }

            $user->save();

        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //recuperando o id do usuário logado
        $loggedId = Auth::id();

        if($loggedId != $id){

            $user = User::find($id);
            $user->delete();

        }

        return redirect()->route('users.index');

    }
}
