<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\Station;
use App\Train;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::all();
        return view('admin.schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stations = Station::all();
        $train = Train::find(session()->get('train'));
        return view('admin.schedule.create', compact('stations', 'train'));
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
            'from' => 'required',
            'to' => 'required|different:from',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'cost' => 'required|integer|min:1',
        ]);

        Schedule::create([
            'train_id' => session()->get('train'),
            'from_id' => $request->from,
            'to_id' => $request->to,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'cost' => $request->cost,
        ]);
        return redirect()->back()->withSuccess('Schedule added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        $schedule = Schedule::find($schedule->id);
        return view('admin.schedule.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required|different:from',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'cost' => 'required|min:1',
        ]);

        $schedule = Schedule::find($schedule->id);

        $schedule->from_id = $request->from;
        $schedule->to_id = $request->to;
        $schedule->departure_time = $request->departure_time;
        $schedule->arrival_time = $request->arrival_time;
        $schedule->cost = $request->cost;

        $schedule->save();

        return redirect()->back()->withSuccess('Schedule updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $redirect = redirect()->back();

        try {
            $schedule->delete();
            $redirect->withSuccess('Schedule Removed.');
        } catch (\Illuminate\Database\QueryException$e) {
            $redirect->withFail('Record has associated entries. Action aborted.');
        } catch (\Exception$e) {
            $redirect->withFail('Could not perform request');
        }

        return $redirect;

    }

    public function trainSchedule($id)
    {
        $train_schedules = Schedule::where('train_id', $id)->get();
        $train = Train::find($id);
        session()->put('train', $id);

        return view('admin.train.schedule', compact('train_schedules', 'train'));
    }
}
