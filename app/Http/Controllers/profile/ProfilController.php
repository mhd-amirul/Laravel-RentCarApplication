<?php

namespace App\Http\Controllers\profile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TokoRequest;
use App\Models\makeShop;
use App\Models\shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilController extends Controller
{

    public function index()
    {
        return view('pages.profile.profil')
                ->with(
                    [
                        'title' => 'Profile',
                        'data' => User::where('id', auth()->user()->id)->first(),
                        'makeshop' => makeShop::where('user_id', auth()->user()->id)->first(),
                    ]
                );
    }

    public function edit(User $profil)
    {
        return view('pages.profile.edit')
                ->with(
                    [
                        'title' => 'Edit Profile',
                        'data' => User::findOrFail($profil->id)
                    ]
                );
    }

    public function update(Request $request, User $profil)
    {
        $db = User::findOrFail($profil->id);

        $rules = [
            'username' => 'required|min:5',
            'image' => 'image|file|max:1024'
        ];

        if ($request->email != $db->email) {
            $rules['email'] = 'email|unique:users';
        }
        if ($request->no_hp != $db->no_hp) {
            $rules['no_hp'] = 'min:3|unique:users';
        }

        $data = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldimg) {
                Storage::delete($request->oldimg);
            }
            $data['image'] = $request->file('image')->store('Profile');
        }

        $db->update($data);
        return redirect()->route('profil.index')->with('success', 'Profil Berhasil di Ubah');
    }

    public function create()
    {
        return view('pages.profile.daftar_rental')->with(['title' => 'Buka Toko']);
    }

    public function store(TokoRequest $request)
    {
        $data = $request->all();
        if ($request->file('img_ktp')) {
            $data['img_ktp'] = $request->file('img_ktp')->store('ktp');
        }

        if ($request->file('img_siu')) {
            $data['img_siu'] = $request->file('img_siu')->store('surat_ijin_usaha');
        }

        if ($request->file('pas_foto')) {
            $data['pas_foto'] = $request->file('pas_foto')->store('pas_foto');
        }

        if ($request->file('foto_usaha')) {
            $data['foto_usaha'] = $request->file('foto_usaha')->store('foto_usaha');
        }

        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::random(50);

        makeShop::create($data);
        return redirect()->route('profil.index')->with('success', 'Harap menunggu verifikasi admin!');
    }

    public function changePass(User $profil)
    {
        # code...
        return view('pages.profile.changepass')
            ->with(
                [
                    'title' => 'Change Password',
                    'user' => User::findOrFail($profil->id)
                ]
            );
    }

    public function updatePass(Request $request, User $profil)
    {
        $user = User::findOrFail($profil->id);

        $rules = [
                'password' => 'required',
                'newpassword' => 'required|min:5',
                'confirmPassword' => 'required|same:newpassword'
            ];

            if (!Hash::check($request->password, $user->password)) {
            # code...
            return redirect()
                ->route('changePass',$profil->slug)
                ->with('failed', 'Password lama tidak sesuai');
        }

        $val = $request->validate($rules);
        $val['password'] = Hash::make($val['newpassword']);
        $user->update($val);
        return redirect()
            ->route('profil.index')
            ->with('success', 'Password Berhasil di Ubah');
    }

    public function updaterole()
    {
        # code...
        $user = User::where('id', auth()->user()->id)->first();
        $user->role = 'rental';
        $shop = shop::where('user_id', $user->id)->first();
        $shop->status = 'active';

        $shop->save();
        $user->save();
        makeShop::where('user_id', $user->id)->delete();
        return redirect()->route('profil.index')->with('success', 'Selamat Bergabung di RentCar');
    }

    public function declinems($id)
    {
        $rm = makeShop::findOrFail($id);
        if ($rm->img_ktp) {
            # code...
            Storage::delete($rm->img_ktp);
        }
        if ($rm->img_siu) {
            # code...
            Storage::delete($rm->img_siu);
        }
        if ($rm->pas_foto) {
            # code...
            Storage::delete($rm->pas_foto);
        }
        if ($rm->foto_usaha) {
            # code...
            Storage::delete($rm->foto_usaha);
        }

        $rm->delete();
        return redirect()->route('profil.index');
    }
}
