<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMobilRequest;
use App\Http\Requests\MobilUpdateRequest;
use App\Models\alternatif;
use App\Models\car;
use App\Models\kriteria;
use App\Models\nilai;
use App\Models\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class adminCarController extends Controller
{
    public function addCarAdmin($id)
    {
        # code...
        return view('pages.admin.pages-admin.allshops.allcars.tambah')
            ->with(
                [
                    'shop' => shop::findorfail($id),
                    'title' => 'Tambah Mobil',
                    'kriteria' => kriteria::all(),
                    'alternatif' => alternatif::all()
                ]
            );
    }

    public function createCarAdmin(CreateMobilRequest $request, $id)
    {
        $data = $request->all();
        if ($request->file('gambar1')) {
            $data['gambar1'] = $request->file('gambar1')->store('gambar1');
        }
        if ($request->file('gambar2')) {
            $data['gambar2'] = $request->file('gambar2')->store('gambar2');
        }
        if ($request->file('gambar3')) {
            $data['gambar3'] = $request->file('gambar3')->store('gambar3');
        }
        if ($request->file('gambar4')) {
            $data['gambar4'] = $request->file('gambar4')->store('gambar4');
        }
        if ($request->file('gambar5')) {
            $data['gambar5'] = $request->file('gambar5')->store('gambar5');
        }

        $kriteria = kriteria::all();
        $data['kata_kunci'] = $data['deskripsi'].', ';
        foreach ($kriteria as $k) {
            # code...
            $name = str_replace(' ','_',$k->nama.'_id');
            $db = alternatif::where('id', $data[$name])->first();
            if ($db->kriteria_id == $k->id) {
                $data['kata_kunci'] .= $db->nama.', ';
            }
        }
        $shop = shop::where('id', $id)->first();
        $data['shop_id'] = $id;
        $data['user_id'] = $shop->user_id;
        $car = car::create($data);

        foreach ($kriteria as $k) {
            # code...
            $name = str_replace(' ','_',$k->nama.'_id');
            $db = alternatif::where('id', $data[$name])->first();
            if ($db['kriteria_id'] == $k->id) {
                # code...
                $nilai = [
                    'car_id' => $car->id,
                    'kriteria_id' => $k->id,
                    'alternatif_id' => $data[$name],
                    'nilai' => $db->nilai
                ];
                nilai::create($nilai);
            }
        }
        return response()->json([$data, $car, $nilai]);
        return redirect()
            ->route('allshops.show',$id)
            ->with('success', 'Berhasil Menambah Mobil Baru');
    }

    public function editCarAdmin($id)
    {
        # code...
        return view('pages.admin.pages-admin.allshops.allcars.edit')
            ->with(
                [
                    'car' => car::findorfail($id),
                    'title' => 'Edit Mobil',
                    'kriteria' => kriteria::all(),
                    'alternatif' => alternatif::all()
                ]
            );
    }

    public function updateCarAdmin(MobilUpdateRequest $request, $id)
    {
        # code...
        $database = car::findOrFail($id);
        $data = $request->all();
        // return response()->json($data);
                
        if ($request->file('gambar1')) {
            if ($request->oldgambar1) {
                Storage::delete($request->oldgambar1);
            }
            $data['gambar1'] = $request->file('gambar1')->store('gambar1');
        }

        if ($request->file('gambar2')) {
            if ($request->oldgambar2) {
                Storage::delete($request->oldgambar2);
            }
            $data['gambar2'] = $request->file('gambar2')->store('gambar2');
        }

        if ($request->file('gambar3')) {
            if ($request->oldgambar3) {
                Storage::delete($request->oldgambar3);
            }
            $data['gambar3'] = $request->file('gambar3')->store('gambar3');
        }

        if ($request->file('gambar4')) {
            if ($request->oldgambar4) {
                Storage::delete($request->oldgambar4);
            }
            $data['gambar4'] = $request->file('gambar4')->store('gambar4');
        }

        if ($request->file('gambar5')) {
            if ($request->oldgambar5) {
                Storage::delete($request->oldgambar5);
            }
            $data['gambar5'] = $request->file('gambar5')->store('gambar5');
        }

        $kriteria = kriteria::all();
        $data['kata_kunci'] = $data['deskripsi'].', ';
        foreach ($kriteria as $k) {
            # code...
            $name = str_replace(' ','_',$k->nama.'_id');
            $db = alternatif::where('id', $data[$name])->first();
            $dbNilai = nilai::where(['car_id' => $id, 'kriteria_id' => $k->id])->first();

            if ($db->kriteria_id == $k->id) {
                $data['kata_kunci'] .= $db->nama.', ';
            }

            if ($dbNilai) {
                # code...
                $nilai = [
                    'car_id' => $id,
                    'kriteria_id' => $k->id,
                    'alternatif_id' => $data[$name],
                    'nilai' => $db->nilai
                ];
                $dbNilai->update($nilai);
            }
        }
        $database->update($data);

        return redirect()
            ->route('allshops.show',$database->shop_id)
            ->with('success', 'Data Mobil Berhasil di Ubah');
    }
}