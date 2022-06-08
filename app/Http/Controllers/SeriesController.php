<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index()
    {
//        $series = DB::select('SELECT nome FROM series');
//        $series = Serie::all();
        $series = Serie::query()->orderBy('nome')->get();

        return view('series.index')->with('series', $series);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
//        $nome = $request->input('nome');

//        if (DB::insert('INSERT INTO series (nome) VALUES(?)', [$nome])) {
//            return redirect('/series');
//        } else {
//            return "ERRO";
//        }
//        $serie = new Serie();
//        $serie->nome = $request->input('nome');
//        $serie->save();
        Serie::create($request->all());

        return redirect('/series');
    }
}
