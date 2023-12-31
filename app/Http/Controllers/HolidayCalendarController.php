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
        $results = HolidayCalendar::orderBy('id','desc')->whereYear('holiday_date', $year)->paginate(20);

        return view('admin.modules.holiday.index', compact('results'));
    }
    public function create()
    {
        return view('admin.modules.holiday.create');
    }
    public function store(Request $request)
    {
        // Validate and store the new holiday record
        //return $request->all();
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
        // Validate and update the holiday record
        //return $request->all();
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
