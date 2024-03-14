<?php

namespace App\Http\Controllers;

use App\Models\Tipebus;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TransportasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipebus = Tipebus::orderBy('name')->get();
        $tiket = Tiket::with('tipebus')->orderBy('kode')->orderBy('name')->get();
        return view('server.tiket.index', compact('tipebus', 'tiket'));
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
        $this->validate($request, [
            'name' => 'required',
            'kode' => 'required',
            'jumlah' => 'required',
            'tipebus_id' => 'required'
        ]);

        Tiket::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'kode' => strtoupper($request->kode),
                'jumlah' => $request->jumlah,
                'tipebus_id' => $request->tipebus_id,
            ]
        );

        if ($request->id) {
            return redirect()->route('tiket.index')->with('success', 'Success Update Tiket!');
        } else {
            return redirect()->back()->with('success', 'Success Add Tiket!');
        }
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
        $tipebus = Tipebus::orderBy('name')->get();
        $tiket = Tiket::find($id);
        return view('server.tiket.edit', compact('tipebus', 'tiket'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tiket::find($id)->delete();
        return redirect()->back()->with('success', 'Success Delete Tiket!');
    }
}
