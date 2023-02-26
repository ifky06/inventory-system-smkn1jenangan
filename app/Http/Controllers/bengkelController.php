<?php

namespace App\Http\Controllers;

use App\Models\bengkel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;

class bengkelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=bengkel::all();
        $data2=User::where('status','=',1)
                    ->whereNull('pj')->get();
        return view('bengkel.view',compact('data','data2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'bengkel'=>'required',
            'pj'=>'required',
        ],[
            'bengkel.required'=>'Nama Bengkel tidak boleh kosong',
            'pj.required'=>'Penanggung Jawab Tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }
        $pj=User::find($request->pj);
        bengkel::create([
            'bengkel'=>$request->bengkel,
            'id_pj'=>$request->pj,
        ]);
        $pj->update([
            'pj'=>$request->bengkel,
        ]);
        Alert::toast('Tambah Data Berhasil', 'success');
        return redirect('/bengkel');
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
        //
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
        $validator=Validator::make($request->all(),[
            'bengkel'=>'required',
            'pj'=>'required',
        ],[
            'bengkel.required'=>'Nama Bengkel tidak boleh kosong',
            'pj.required'=>'Penanggung Jawab Tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data=bengkel::find($id);

        $data->update([
            'bengkel'=>$request->bengkel,
            'id_pj'=>$request->pj,
        ]);
        Alert::toast('Edit Data Berhasil', 'success');
        return redirect('/bengkel');
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
