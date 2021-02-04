<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    /**
     * ProfileController constructor.
     */
    public function __construct(){

        //adicionando middleware para autenticação
        $this->middleware('auth');
    }

    public function index(){

        //recuperando id do usuário logado
        $loggedId = Auth::id();

        //recuperando usuário
        $user = User::find($loggedId);

        if($user){

            return view('admin.profile.index', ['user' => $user]);
        }

        return redirect()->route('admin');
    }

    public function save(Request $request)
    {

        //recuperando id do usuário logado
        $id = Auth::id();
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

                return redirect()->route('profile', ['user' => $id])->withErrors($validator);
            }

            $user->save();

            return redirect()->route('profile')->with('warning', 'Usuário alterado com sucesso');

        }

        return redirect()->route('profile');
    }


}
