<?php

namespace App\Http\Controllers;

use App\Train;
use App\TrainType;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trains = Train::all();
        $train_types = TrainType::all();
        return view('admin.train.index', compact('trains', 'train_types'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'train_type' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        Train::create([
            'name' => $request->name,
            'train_type_id' => $request->train_type,
            'capacity' => $request->capacity,
        ]);

        return redirect()->back()->withSuccess('Train added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function show(Train $train)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function edit(Train $train)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Train $train)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'train_type' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        $train = Train::find($train->id);

        $train->name = $request->name;
        $train->train_type = $request->train_type;
        $train->capacity = $request->capacity;

        $train->save();

        return redirect()->back()->withSuccess('Update successful.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function destroy(Train $train)
    {
        $redirect = redirect()->back();

        try {
            $train->delete();
            $redirect->withSuccess('Train Deleted.');
        } catch (\Illuminate\Database\QueryException$e) {
            $redirect->withFail('Record has associated entries. Action aborted.');
        } catch (\Exception$e) {
            $redirect->withFail('Could not perform request');
        }

        return $redirect;

    }
}
