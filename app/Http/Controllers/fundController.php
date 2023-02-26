<?php

namespace App\Http\Controllers;

use App\Models\fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;

class fundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=fund::all();
        return view('sumberdana.view',compact('data'));
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
            'sd'=>'required',
        ],[
            'sd.required'=>'Sumber Dana tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        fund::create([
            'nama'=>$request->sd,
        ]);
        Alert::toast('Tambah Data Berhasil', 'success');
        return redirect('/sumber_dana');
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
            'sd'=>'required',
        ],[
            'sd.required'=>'Sumber Dana tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data=fund::find($id);

        $data->update([
            'nama'=>$request->sd,
        ]);
        Alert::toast('Edit Data Berhasil', 'success');
        return redirect('/sumber_dana');
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
