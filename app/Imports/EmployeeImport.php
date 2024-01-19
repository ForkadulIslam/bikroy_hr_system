<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Extract data for the User model
        if (isset($row['role_id'])) {
            try {
                DB::beginTransaction();
                $userData = [
                    'role_id' => $row['role_id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['password']),
                ];

                $user = User::create($userData);

                $row['user_id'] = $user->id;
                $row['date_of_birth'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth']))->toDateString();
                $row['date_of_joining'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_joining']))->toDateString();
                $row['end_of_contract_date'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_of_contract_date']))->toDateString();
                $employeeData = Arr::except($row, array_keys($userData));
                Employee::create($employeeData);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error during user and employee data insertion: ' . $e->getMessage());
            }
        }
    }
}
