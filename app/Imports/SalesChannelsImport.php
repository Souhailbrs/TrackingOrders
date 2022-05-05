<?php

namespace App\Imports;
use App\Models\SalesChannels;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SalesChannelsImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SalesChannels([
            'title_en'=> $row[0],
            'title_ar'=> $row[1],
            'shop_url'=> $row[2],
            'owner_email'=> $row[3],
            'owner_password'=> Hash::make($row[4]),
            'owner_phone'=> $row[5],
            'sales_channel_type_id'=> intval($row[6]),
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
