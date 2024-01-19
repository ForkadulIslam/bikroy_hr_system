<?php

namespace App\Imports;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */


    public function model(array $row)
    {

        if(isset($row['id'])){
            try {
                $attDate = Carbon::createFromFormat('d/m/y', $row['date'])->toDateString();
                $attTime = Carbon::createFromFormat('H:i', trim($row['time']))->toTimeString();
                Attendance::create([
                    'attendance_id' => $row['id'],
                    'attendance_date' => $attDate,
                    'attendance_time' => $attTime
                ]);
            }catch (\Exception $e){
                Log::error($e);
            }
        }
    }
}
