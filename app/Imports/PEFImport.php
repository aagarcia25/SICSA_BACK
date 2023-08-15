<?php

namespace App\Imports;

use App\Models\PEF;
use Maatwebsite\Excel\Concerns\ToModel;

class PEFImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PEF([
            //
        ]);
    }
}
