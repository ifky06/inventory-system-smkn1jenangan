<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Auth;
use Alert;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.view');
    }
    public function username(){
        return view('profile.username');
    }
    public function password(){
        return view('profile.password');
    }
    public function editForm(){
        return view('profile.edit');
    }
    public function usernameEdit(Request $request){
        $id=auth()->user()->id;
        $validator=Validator::make($request->all(),[
            'username'=>'required|unique:users,username,'.$id,
        ],[
            'username.required'=>'Username Tidak boleh kosong',
            'username.unique'=>'Username sudah terpakai',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }
        $data=User::find($id);

        $data->update([
            'username'=>$request->username,
        ]);

        Alert::toast('Username Berhasil Diubah', 'success');
        return redirect('/profile');
    }
    public function PasswordEdit(Request $request){
        $id=auth()->user()->id;
        $validator=Validator::make($request->all(),[
            'password_lama'=>'required',
            'password'=>'required|min:8',
            'password_confirmation'=>'required',
        ],[
            'password_lama.required'=>'Password Lama Tidak boleh kosong',
            'password.required'=>'Password Baru Tidak boleh kosong',
            'password_confirmation.required'=>'Konfirmasi Password Tidak boleh kosong',
            'password.min'=>'Password kurang dari 8 karakter',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }
        $data=User::find($id);
        $password=auth()->user()->password;
        if (\Hash::check($request->password_lama , $password)) {
            if ($request->password == $request->password_confirmation) {
                $data->update([
                    'password'=>Hash::make($request->password),
                ]);
            } else {
                Alert::toast('Konfirmasi Password Gagal', 'error');
                return back();
            }
        } else {
            Alert::toast('Password Lama Salah', 'error');
            return back();
        }
        Alert::toast('Password Berhasil Diubah', 'success');
        return redirect('/profile');
    }
    public function edit(Request $request){
        $validator=Validator::make($request->all(),[
            'nama'=>'required',
        ],[
            'nama.required'=>'Nama tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }
        $id=auth()->user()->id;
        $data=User::find($id);

        if ($request->has('kosong')) {
            if ($data->foto != "profile.jpg") {
                File::delete('images/profile/'.$data->foto);
            }
            $data->update([
                'name'=>$request->nama,
                'foto'=>"profile.jpg"
            ]);
        }else {
            if ($request->foto=="") {
                $data->update([
                    'name'=>$request->nama,
                ]);
            } else {
                if ($data->foto != "profile.jpg") {
                    File::delete('images/profile/'.$data->foto);
                }
                $image_name="profile".$id.time().'.'.$request->foto->extension();

                $request->foto->move(public_path('images/profile'),$image_name);
                $data->update([
                    'name'=>$request->nama,
                    'foto'=>$image_name
                ]);
            }
        }

        Alert::toast('Profile Berhasil Diubah', 'success');
        return redirect('/profile');
    }
}
