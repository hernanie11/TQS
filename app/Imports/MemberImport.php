<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;


class MemberImport implements ToModel,  WithHeadingRow, SkipsOnError, WithValidation
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        return new Member([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'gender' => $row['gender'],
            'birthday' => $row['birthday'],
            'barangay' => $row['barangay'],
            'municipality' => $row['municipality'],
            'province' => $row['province'],
            'email' => $row['email'],
            'mobile_number' => $row['mobile_number'],
            'is_active' => $row['is_active'],
            'created_by' => $row['created_by'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.mobile_number' => ['unique:members,mobile_number']
        ];
    }
}
