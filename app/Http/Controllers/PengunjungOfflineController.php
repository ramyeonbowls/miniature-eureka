<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OfflineVisitors;

class PengunjungOfflineController extends Controller
{
    protected $client_id = '';
    public function __construct()
    {
        $this->middleware('guest');
        $this->client_id = config('app.client_id', '');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $success = $request->session()->get('success');
        return view('offlinevisitor', compact('success'));
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
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'nik'       => 'required|regex:/^[0-9]{12,16}$/|max:50', 
            'gender'    => 'required|in:L,P',
        ]);

        OfflineVisitors::create([
            'client_id' => $this->client_id,
            'name'      => $request->name,
            'email'     => $request->email,
            'nik'       => $request->nik,
            'gender'    => $request->gender,
            'date'      => Carbon::now('Asia/Jakarta')->format('Y-m-d')
        ]);

        return redirect('/offline-visitor')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
