<?php

namespace App\Http\Controllers;

use App\Models\HolidayCalendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HolidayCalendarController extends Controller
{

    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    public function index(){
        $year = isset(request()->year) ? request()->year : Carbon::now()->year;
        $results = HolidayCalendar::orderBy('holiday_date','desc')->whereYear('holiday_date', $year)->paginate(20);
        //return $results;
        return view('admin.modules.holiday.index', compact('results'));
    }
    public function create()
    {
        return view('admin.modules.holiday.create');
    }
    public function store(Request $request)
    {

        HolidayCalendar::create($request->all());

        return redirect()->route('holiday.index')->with('message', 'Holiday created successfully!');
    }

    public function edit($id)
    {
        $holiday = HolidayCalendar::findOrFail($id);
        return view('admin.modules.holiday.edit', compact('holiday'));
    }

    public function update(Request $request, $id)
    {
        $holiday = HolidayCalendar::findOrFail($id);
        $holiday->update($request->all());

        return redirect()->route('holiday.index')->with('message', 'Holiday updated successfully!');
    }

    public function destroy($id)
    {
        // Delete the holiday record
        $holiday = HolidayCalendar::findOrFail($id);
        $holiday->delete();
        return redirect()->route('holiday.index')->with('message', 'Holiday deleted successfully!');
    }
}
