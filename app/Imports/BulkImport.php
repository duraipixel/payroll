<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;  
use Maatwebsite\Excel\Concerns\ToModel;

class BulkImport implements ToModel
{
    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.employee_code' => 'required',
             '*.institution_name' => 'required',
             '*.institution_code' => 'required',
         ])->validate();
  
        /*foreach ($rows as $row) {
            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => bcrypt($row['password']),
            ]);
        }*/
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            //
        ]);
    }
}
