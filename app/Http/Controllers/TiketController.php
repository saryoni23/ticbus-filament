<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rute;
use App\Models\Tipebus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruteAwal = Rute::orderBy('start')->get()->groupBy('start');
        if (count($ruteAwal) > 0) {
            foreach ($ruteAwal as $key => $value) {
                $data['start'][] = $key;
            }
        } else {
            $data['start'] = [];
        }
        $ruteAkhir = Rute::orderBy('end')->get()->groupBy('end');
        if (count($ruteAkhir) > 0) {
            foreach ($ruteAkhir as $key => $value) {
                $data['end'][] = $key;
            }
        } else {
            $data['end'] = [];
        }
        $tipebus = Tipebus::orderBy('name')->get();
        return view('livewire.tiket', compact('data', 'tipebus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->tipebus) {
            $tipebus = Tipebus::find($request->tipebus);
            $data = [
                'start' => $request->start,
                'end' => $request->end,
                'tipebus' => $tipebus->id,
                'waktu' => $request->waktu,
            ];
            $data = Crypt::encrypt($data);
            return redirect()->route('show', ['id' => $tipebus->slug, 'data' => $data]);
        } else {
            $this->validate($request, [
                'rute_id' => 'required',
                'waktu' => 'required',
            ]);

            $huruf = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $kodeOrder = strtoupper(substr(str_shuffle($huruf), 0, 7));

            $rute = Rute::with('tiket.tipebus')->find($request->rute_id);
            // $jumlah_kursi = $rute->transportasi->jumlah + 2;
            // $kursi = (int) floor($jumlah_kursi / 5);
            // $kode = "ABCDE";
            // $kodeKursi = strtoupper(substr(str_shuffle($kode), 0, 1) . rand(1, $kursi));

            $waktu = $request->waktu . " " . $rute->jam;

            Order::Create([
                'kode' => $kodeOrder,
                // 'kursi' => $request,
                'waktu' => $waktu,
                'total' => $rute->harga,
                'rute_id' => $rute->id,
                'penumpang_id' => Auth::user()->id
            ]);

            return redirect()->back()->with('success', 'Order Tiket ' . $rute->tiket->tipebus->name . ' Success!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $data)
    {
        $data = Crypt::decrypt($data);
        $tipebus = Tipebus::find($data['tipebus']);
        $rute = Rute::with('tiket')->where('start', $data['start'])->where('end', $data['end'])->get();
        if ($rute->count() > 0) {
            foreach ($rute as $val) {
                $order = Order::where('rute_id', $val->id)->where('waktu')->count();
                if ($val->tiket) {
                    $kursi = Order::find($val->tiket_id)->jumlah - $order;
                    if ($val->tiket->tipebus_id == $tipebus->id) {
                        $dataRute[] = [
                            'harga' => $val->harga,
                            'start' => $val->start,
                            'end' => $val->end,
                            'tujuan' => $val->tujuan,
                            'tiket' => $val->tiket->name,
                            'kode' => $val->tiket->kode,
                            'kursi' => $kursi,
                            'waktu' => $data['waktu'],
                            'id' => $val->id,
                        ];
                    }
                }
            }
            sort($dataRute);
        } else {
            $dataRute = [];
        }
        $id = $tipebus->name;
        return view('client.show', compact('id', 'dataRute'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
