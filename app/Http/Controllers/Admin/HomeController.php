<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        //Contagem de visitantes
        $visitsCount = Visitor::count();

        //Contagem de usuários online
            //pega a data e hora atual -5 minutos
        $datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access', '>=', $datelimit)->groupby('ip')->get();
        $onlineCount = count($onlineList);

        //Contagem de páginas
        $pageCount = Page::count();

        //Contagem de usuários
        $userCount = User::count();

        $pagePie = [

            'Teste 1' => 100,
            'Teste 2' => 200,
            'Teste 3' => 300
        ];

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));


        return view('admin.home', [

            'visitsCount' => $visitsCount,
            'onlineCount' => $onlineCount,
            'pageCount'   => $pageCount,
            'userCount'   => $userCount,
            'pageLabels'  => $pageLabels,
            'pageValues'  => $pageValues
        ]);
    }
}
