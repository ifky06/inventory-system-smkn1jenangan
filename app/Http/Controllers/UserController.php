<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Alert;

class UserController extends Controller
{
    public function adminIndex(){
        $data=User::where('status','=',0)->get();
        return view('user.admin',compact('data'));
    }
    public function adminStore(Request $request){
        $validator=Validator::make($request->all(),[
        // $this->validate($request,[
            'nama'=>'required',
            'username'=>'required|unique:users',
            'password'=>'required|min:8',
        ],[
            'nama.required'=>'Nama tidak boleh kosong',
            'username.required'=>'Username Tidak boleh kosong',
            'username.unique'=>'Username sudah terpakai',
            'password.required'=>'Password Tidak boleh kosong',
            'password.min'=>'Password kurang dari 8 karakter',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status'=>0,
            'foto'=>"profile.jpg"
        ]);

        Alert::toast('Input Data Berhasil', 'success');
        return redirect('/user_admin');
    }
    public function adminUpdate(Request $request,$id){
        $user=User::find($id);
        $validator=Validator::make($request->all(),[
        // $this->validate($request,[
            'nama'=>'required',
            'username'=>'required|unique:users,username,'.$id,
        ],[
            'nama.required'=>'Nama tidak boleh kosong',
            'username.required'=>'Username Tidak boleh kosong',
            'username.unique'=>'Username sudah terpakai',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
            // ->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        if ($request->password =="") {
            $user->update([
                'name' => $request->nama,
                'username' => $request->username,
            ]);
        } else {
            $user->update([
                'name' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
        }

        Alert::toast('Edit Data Berhasil', 'success');
        return redirect('/user_admin');
    }
    
    

    public function pjIndex(){
        $data=User::where('status','=',1)->get();
        return view('user.pj',compact('data'));
    }
    public function pjStore(Request $request){
        $validator=Validator::make($request->all(),[
        // $this->validate($request,[
            'nama'=>'required',
            'username'=>'required|unique:users',
            'password'=>'required|min:8',
        ],[
            'nama.required'=>'Nama tidak boleh kosong',
            'username.required'=>'Username Tidak boleh kosong',
            'username.unique'=>'Username sudah terpakai',
            'password.required'=>'Password Tidak boleh kosong',
            'password.min'=>'Password kurang dari 8 karakter',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
            // ->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status'=>1,
            'foto'=>"profile.jpg"
        ]);

        Alert::toast('Input Data Berhasil', 'success');
        return redirect('/user_pj');
    }
    public function pjUpdate(Request $request,$id){
        $user=User::find($id);
        $validator=Validator::make($request->all(),[
        // $this->validate($request,[
            'nama'=>'required',
            'username'=>'required|unique:users,username,'.$id,
        ],[
            'nama.required'=>'Nama tidak boleh kosong',
            'username.required'=>'Username Tidak boleh kosong',
            'username.unique'=>'Username sudah terpakai',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
            // ->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        if ($request->password =="") {
            $user->update([
                'name' => $request->nama,
                'username' => $request->username,
            ]);
        } else {
            $user->update([
                'name' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
        }

        Alert::toast('Edit Data Berhasil', 'success');
        return redirect('/user_pj');
    }
}
