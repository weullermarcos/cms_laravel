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

    public function index(Request $request)
    {

        //recebendo o intervalo de dias
        $interval = intval($request->input('interval', 30));

        if($interval > 180){
            $interval = 180;
        }

        $dateInterval = date('Y-m-d H:i:s', strtotime('-' . $interval . 'days'));

        //Contagem de visitantes
        $visitsCount = Visitor::where('date_access', '>=', $dateInterval)->count();

        //Contagem de usuários online
            //pega a data e hora atual -5 minutos
        $datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));

        $onlineList = Visitor::select('ip')
            ->where('date_access', '>=', $datelimit)
            ->groupby('ip')
            ->get();

        $onlineCount = count($onlineList);

        //Contagem de páginas
        $pageCount = Page::count();

        //Contagem de usuários
        $userCount = User::count();

        //Lista geral de visitantes:
        $visitsAll = Visitor::selectRaw('page, count(page) as c')
            ->where('date_access', '>=', $dateInterval)
            ->groupBy('page')
            ->get();

        $pagePie = [];

        foreach ($visitsAll as $visit){

            $pagePie[$visit['page']] = intval($visit['c']);
        }

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));


        return view('admin.home', [

            'visitsCount'  => $visitsCount,
            'onlineCount'  => $onlineCount,
            'pageCount'    => $pageCount,
            'userCount'    => $userCount,
            'pageLabels'   => $pageLabels,
            'pageValues'   => $pageValues,
            'dateInterval' => $interval
        ]);
    }
}
