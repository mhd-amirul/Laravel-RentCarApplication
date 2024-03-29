<?php

namespace App\Http\Controllers\admin;

use App\Models\car;
use App\Models\shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class allShopsController extends Controller
{
    public function index()
    {
        return view('pages.admin.pages-admin.allshops.allshops')
            ->with(
                [
                    'title' => 'Data Toko',
                    'shop' => shop::orderBy('id')->filterShop(request(['searchShop']))->get()
                ]
            );
    }

    public function create()
    {
        return view('pages.admin.pages-admin.allshops.tambah')
            ->with(
                [
                    'title' => 'Tambah Toko',
                    'users' => User::where('role', 'user')->get()
                ]
            );
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'status' => 'required',
            'slug' => 'required|unique:shops',
            'nm_pu' => 'required',
            'nm_usaha' => 'required',
            'alamat' => 'required',
            'nik' => 'required|integer|digits:16|unique:shops',
            'img_ktp' => 'image|file|max:1024',
            'img_siu' => 'image|file|max:1024',
            'pas_foto' => 'image|file|max:1024',
            'foto_usaha' => 'image|file|max:1024'
        ];

        $request['slug'] = Str::random(50);
        $request['status'] = 'active';
        $data = $request->validate($rules);

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

        $user = User::where('id', $request['user_id'])->first();
        $user['role'] = 'rental';
        $user->save();

        shop::create($data);
        return redirect()->route('allshops.index')->with('success', 'Toko berhasil dibuat');
    }


    public function show(shop $shop)
    {
        return view('pages.admin.pages-admin.allshops.show')
            ->with(
                [
                    'title' => 'Detail Toko',
                    // 'car' => car::where('shop_id', $id)->filter(request(['search']))->get(),
                    'car' => car::where('shop_id', $shop->id)->OrderBy('id')->get(),
                    'shop' => $shop,

                ]
            );
    }

    public function edit(shop $shop)
    {
        return view('pages.admin.pages-admin.allshops.edit')
            ->with(
                [
                    'data' => $shop,
                    'title' => 'Edit Toko'
                ]
            );
    }

    public function update(Request $request, shop $shop)
    {
        $rules = [
            'user_id' => '',
            'nm_pu' => 'required',
            'nm_usaha' => 'required',
            'alamat' => 'required',
            'img_ktp' => 'image|file|max:1024',
            'img_siu' => 'image|file|max:1024',
            'pas_foto' => 'image|file|max:1024',
            'foto_usaha' => 'image|file|max:1024'
        ];

        if ($request->nik != $shop->nik) {
            $rules['nik'] = 'required|integer|digits:16|unique:shops';
        }

        $data = $request->validate($rules);

        if ($request->file('img_ktp')) {
            if ($request->oldgambar1) {
                Storage::delete($request->oldgambar1);
            }
            $data['img_ktp'] = $request->file('img_ktp')->store('ktp');
        }
        if ($request->file('img_siu')) {
            if ($request->oldgambar2) {
                Storage::delete($request->oldgambar2);
            }
            $data['img_siu'] = $request->file('img_siu')->store('surat_ijin_usaha');
        }
        if ($request->file('pas_foto')) {
            if ($request->oldgambar3) {
                Storage::delete($request->oldgambar3);
            }
            $data['pas_foto'] = $request->file('pas_foto')->store('pas_foto');
        }
        if ($request->file('foto_usaha')) {
            if ($request->oldgambar4) {
                Storage::delete($request->oldgambar4);
            }
            $data['foto_usaha'] = $request->file('foto_usaha')->store('foto_usaha');
        }

        $shop->update($data);
        return redirect()->route('allshops.show', $shop->slug)->with('success', 'Informasi toko berhasil diubah');
    }

    public function destroy(shop $shop)
    {
        $cars = car::where('shop_id', $shop->id)->get();

        if ($shop->img_ktp) {
            # code...
            Storage::delete($shop->img_ktp);
        }
        if ($shop->img_siu) {
            # code...
            Storage::delete($shop->img_siu);
        }
        if ($shop->pas_foto) {
            # code...
            Storage::delete($shop->pas_foto);
        }
        if ($shop->foto_usaha) {
            # code...
            Storage::delete($shop->foto_usaha);
        }

        if ($cars != null) {
            # code...
            foreach ($cars as $car) {
                # code...
                if ($car->gambar1) {
                    # code...
                    Storage::delete($car->gambar1);
                }
                if ($car->gambar2) {
                    # code...
                    Storage::delete($car->gambar2);
                }
                if ($car->gambar3) {
                    # code...
                    Storage::delete($car->gambar3);
                }
                if ($car->gambar4) {
                    # code...
                    Storage::delete($car->gambar4);
                }
                if ($car->gambar5) {
                    # code...
                    Storage::delete($car->gambar5);
                }
            }
        }

        $user = User::where('id', $shop->user_id)->first();
        $user['role'] = 'user';
        $user->save();

        $shop->delete();
        return redirect()
            ->route('allshops.index')
            ->with('success', 'Toko berhasil dihapus');
    }

    public function destroyCar(car $car)
    {
        if ($car->gambar1) {
            # code...
            Storage::delete($car->gambar1);
        }
        if ($car->gambar2) {
            # code...
            Storage::delete($car->gambar2);
        }
        if ($car->gambar3) {
            # code...
            Storage::delete($car->gambar3);
        }
        if ($car->gambar4) {
            # code...
            Storage::delete($car->gambar4);
        }
        if ($car->gambar5) {
            # code...
            Storage::delete($car->gambar5);
        }

        $car->delete();
        return redirect()
            ->route('allshops.show', $car->shop->slug)
            ->with('success', 'Mobil berhasil dihapus');
    }
}
