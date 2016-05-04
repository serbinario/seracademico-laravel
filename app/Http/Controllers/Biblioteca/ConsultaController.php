<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $total = 10; //total de linhas da query

        $my_query = \DB::table('responsaveis')
            ->orderBy('responsaveis.nome','DESC')
            ->paginate(2);

        //dd(compact('my_query'));
        return \View::make('biblioteca.consulta.index')->with(compact('my_query'));

        //return view('default.index');
    }
    
    
}
