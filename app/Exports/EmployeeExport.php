<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::select(
            'name',
            'phone',
            'dob',
            'gender',
            'email',
            'address',
            'city',
            'country',
            'position_id',
            'department_id',
            'designation_id',
            'company_doj',
            'contract_end_date',
            'employee_status',
            'contract_type',
        )->get();
    }

    public function headings(): array
    {
        return [
            "Name",
            "Phone Number",
            "Date of Birth",
            "Gender",
            "Email",
            "Address",
            "City",
            "Country",
            "Position",
            "Department",
            "Unit",
            "Hire Date",
            "Contract End Date",
            "Status",
            "Contract Type",

        ];
    }

    public function map($user): array
    {
        $user->load('position', 'department', 'designation');
        return [
            $user->name,
            $user->phone,
            $user->dob,
            $user->gender,
            $user->email,
            $user->address,
            $user->city,
            $user->country,
            optional($user->position)->name,
            optional($user->department)->name,
            optional($user->designation)->name,
            $user->company_doj,
            $user->contract_end_date,
            ($user->employee_status == 1) ? 'Active' : 'Terminated',
            ($user->contract_type == 1) ? 'Full Time' : 'Part Time',
        ];
    }
}
