<?php

namespace App\Http\Controllers\rental;

use App\Http\Controllers\Controller;
use App\Models\car;
use App\Models\history;
use App\Models\shop;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class activityController extends Controller
{

    public function activityView(shop $shop)
    {
        return view('pages.rental.aktifitas.activity')
            ->with(
                [
                    'title' => 'Aktifitas Toko',
                    'histories' => history::where('shop_id', $shop->id)->where('status', 'on')->get(),
                    'shop' => $shop
                ]
            );
    }

    public function activityAdd(shop $shop)
    {
        return view('pages.rental.aktifitas.tambah')
            ->with(
                [
                    'title' => 'Add Activity',
                    'shop' => $shop,
                    'cars' => car::where('shop_id', $shop->id)->where('stok','standby')->get()
                ]
            );
    }

    public function activityStore(Request $request, shop $shop)
    {
        $request['shop_id'] = $shop->id;
        $request['status'] = 'on';
        $request['slug'] = Str::random(50);
        $rules = [
            'nama_pinjam' => 'required',
            'slug' => 'required|unique:histories',
            'tgl_pinjam' => 'required',
            'nik_pinjam' => 'required|integer|digits:16',
            'batas_pinjam' => 'required',
            'car_id' => 'required',
            'shop_id' => 'required',
            'status' => 'required',
            // 'sim_peminjam' => 'mimes:jpeg,png,jpg|max:300',
            // 'ktp_peminjam' => 'mimes:jpeg,png,jpg|max:300',
            // 'foto_peminjam' => 'mimes:jpeg,png,jpg|max:300',
            // 'berkas_pinjam' => 'mimes:pdf,jpeg,jpg,png|max:1024'
        ];

        $data = $request->validate($rules);
        if ($request->file('sim_peminjam')) {
            $data['sim_peminjam'] = $request->file('sim_peminjam')->store('Berkas-Peminjaman');
        }
        if ($request->file('ktp_peminjam')) {
            $data['ktp_peminjam'] = $request->file('ktp_peminjam')->store('Berkas-Peminjaman');
        }
        if ($request->file('foto_peminjam')) {
            $data['foto_peminjam'] = $request->file('foto_peminjam')->store('Berkas-Peminjaman');
        }
        if ($request->file('berkas_pinjam')) {
            $data['berkas_pinjam'] = $request->file('berkas_pinjam')->store('Berkas-Peminjaman');
        }

        $car = car::where('id', $request['car_id'])->first();
        $car['stok'] = 'onused';
        $car->save();

        history::create($data);
        return redirect()->route('activityView',$shop->slug)->with('success', 'Aktifitas berhasil ditambahkan');
    }

    public function activityShow(history $history)
    {
        date_default_timezone_set('Asia/Jakarta');
        $awal = new DateTime($history->tgl_pinjam);
        $akhir = new DateTime($history->batas_pinjam);
        $now = new DateTime();
        $interval = $akhir->diff($now);

        if($now < $akhir && $history->status == 'on'){
            $sentence = $interval->d . ' days ' . $interval->h . ' hours ' . $interval->i . ' minutes';
            $color = '';
        } elseif ($now > $akhir && $history->status == 'on') {
            $sentence = '-'.$interval->d . ' days ' . '-'.$interval->h . ' hours ' . '-'.$interval->i . ' minutes';
            $color = 'bg-danger text-white';
        } else {
            $sentence = '0 days ' . '0 hours ' . '0 minutes';
            $color = '';
        }

        return view('pages.rental.aktifitas.show')
            ->with(
                [
                    'title' => 'Detail Aktifitas',
                    'shop' => shop::where('id', $history->shop_id)->first(),
                    'history' => $history,
                    'sisa_waktu' => $sentence,
                    'color' => $color
                ]
            );
    }

    public function activityEdit(history $history)
    {
        return view('pages.rental.aktifitas.edit')
            ->with(
                [
                    'title' => 'Add Activity',
                    'history' => $history,
                    'car' => car::where('id', $history->car_id)->first()
                ]
            );
    }

    public function activityUpdate(Request $request, history $history)
    {
        $rules = [
            'nama_pinjam' => 'required',
            'tgl_pinjam' => 'required',
            'batas_pinjam' => 'required',
            // 'sim_peminjam' => 'mimes:jpeg,png|max:300',
            // 'ktp_peminjam' => 'mimes:jpeg,png|max:300',
            // 'foto_peminjam' => 'mimes:jpeg,png|max:300',
            // 'berkas_pinjam' => 'mimes:pdf,jpeg,png|max:1024'
        ];

        if ($request->nik_pinjam != $history->nik_pinjam) {
            $rules['nik_pinjam'] =  'required|integer|digits:16';
        }

        $data = $request->validate($rules);
        if ($request->file('sim_peminjam')) {
            if ($request->oldsim) {
                Storage::delete($request->oldsim);
            }
            $data['sim_peminjam'] = $request->file('sim_peminjam')->store('Berkas-Peminjaman');
        }
        if ($request->file('ktp_peminjam')) {
            if ($request->oldktp) {
                Storage::delete($request->oldktp);
            }
            $data['ktp_peminjam'] = $request->file('ktp_peminjam')->store('Berkas-Peminjaman');
        }
        if ($request->file('foto_peminjam')) {
            if ($request->oldfoto) {
                Storage::delete($request->oldfoto);
            }
            $data['foto_peminjam'] = $request->file('foto_peminjam')->store('Berkas-Peminjaman');
        }
        if ($request->file('berkas_pinjam')) {
            if ($request->oldgambar1) {
                Storage::delete($request->oldgambar1);
            }
            $data['berkas_pinjam'] = $request->file('berkas_pinjam')->store('Berkas-Peminjaman');
        }

        $history->update($data);
        return redirect()->route('activityShow',$history->slug)->with('success', 'Aktifitas berhasil diubah');
    }

    public function activityReturn(history $history)
    {
        # code...
        $history->status = 'off';
        $shop = shop::where('id', $history->shop_id)->first();
        $car = car::where('id', $history->car_id)->first();
        $car->stok = 'standby';

        $history->save();
        $car->save();

        return redirect()->route('activityView', $shop->slug)->with('success', 'Mobil sudah dikembalikan');
    }

    public function activityDelete(history $history)
    {
        # code...
        $car = car::where('id', $history->car_id)->first();
        $shop = shop::where('id', $history->shop_id)->first();

        if ($car->stok == 'onused') {
            $car->stok = 'standby';
            $car->save();
        }

        if ($history->sim_peminjam) {
            # code...
            Storage::delete($history->sim_peminjam);
        }
        if ($history->ktp_peminjam) {
            # code...
            Storage::delete($history->ktp_peminjam);
        }
        if ($history->foto_peminjam) {
            # code...
            Storage::delete($history->foto_peminjam);
        }
        if ($history->berkas_pinjam) {
            # code...
            Storage::delete($history->berkas_pinjam);
        }

        $history->delete();
        return redirect()->route('activityView', $shop->slug)->with('success', 'History dihapus');
    }

    public function activityHistory(shop $shop)
    {
        # code...
        return view('pages.rental.aktifitas.history')
                ->with(
                    [
                        'title' => 'History',
                        'histories' => history::where('shop_id', $shop->id)->where('status', 'off')->get(),
                        'shop' => $shop
                    ]
                );
    }

    public function activityViewCetak(shop $shop)
    {
        $history = history::where('shop_id', $shop->id)
            ->where('status', 'off')
            ->get();
        $cars = car::where('shop_id', $shop->id)->get();

        // $pdf = PDF::loadview('pages.rental.aktifitas.cetak_pdf', ['histories' => $data] );
        // return $pdf->stream('laporan.pdf');
        return view('pages.rental.aktifitas.cetak_pdf')
            ->with(
                [
                    'histories' => $history,
                    'cars' => $cars
                ]
            );
    }
}
