<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all();
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Employee Id',
            'First Name',
            'Last Name',
            'Date Of Birth',
            'Education Qualification',
            'Gender',
            'Address',
            'Email',
            'Phone',
        ];
    }
}
