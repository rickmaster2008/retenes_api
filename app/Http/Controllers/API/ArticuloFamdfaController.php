<?php

namespace App\Http\Controllers\API;

use App\Models\ArticuloFamdfa;
use App\Models\Famdfa;
use App\Models\Ccmcli;
use App\Models\Ccmzon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticuloFamdfaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {   
        //$artdfas = ArticuloFamdfa::where('impneto_min', NULL)->where('impneto_max', NULL)->where('mcodart', $req['mcodart'])->orWhere('mcodart', '')->orWhere('mcodart', NULL)->get();
        $artdfas = ArticuloFamdfa::where([
            ['impneto_min', '=', NULL],
            ['impneto_max', '=', NULL],
            ['mcodart', '=', $req['mcodart']]
        ])->orWhere([
            ['impneto_min', '=', NULL],
            ['impneto_max', '=', NULL],
            ['mcodart', '=', '']
        ])->orWhere([
            ['impneto_min', '=', NULL],
            ['impneto_max', '=', NULL],
            ['mcodart', '=', NULL]
        ])->get();
        $ccmcli = Ccmcli::where('MCODCLI', $req['mcodcli'])->first();
        $ccmzon = Ccmzon::where('MCODZON', $ccmcli['MCODZON'])->first();
        foreach ($artdfas as $ndfa) {
            $dfa = Famdfa::where('MCODDFA', $ndfa['mcoddfa'])->first();
            $ndfa['descuento'] = $dfa;
        }
        return response()->json($artdfas, 200);
    }
    
    public function descuento_general(Request $req) {
        $impneto = $req->input('impneto');
        $mcodcadi = $req->input('mcodcadi');
        $mcondpago = $req->input('mcondpago');
        $mcodcli = $req->input('mcodcli');
        $artdfas = ArticuloFamdfa::where('MCODCADI', $mcodcadi)->where('MCONDPAGO', $mcondpago)->where('impneto_min', '<=', $impneto)->where(function($q) use ($mcodcli) {
            $q->where('MCODCLI', $mcodcli)->orWhere('MCODCLI', NULL);
        })->get();
        foreach ($artdfas as $ndfa) {
            $dfa = Famdfa::where('MCODDFA', $ndfa['mcoddfa'])->first();
            $ndfa['descuento'] = $dfa;
        }
        return response()->json($artdfas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArticuloFamdfa  $articuloFamdfa
     * @return \Illuminate\Http\Response
     */
    public function show(ArticuloFamdfa $articuloFamdfa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArticuloFamdfa  $articuloFamdfa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticuloFamdfa $articuloFamdfa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArticuloFamdfa  $articuloFamdfa
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticuloFamdfa $articuloFamdfa)
    {
        //
    }
}
