<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class OrdersImport implements ToModel, SkipsEmptyRows, WithHeadingRow, WithValidation
{
    use Importable;

    public $id;
    public $country_id;
    public $seller_id;
    public $products_ids;

    public function __construct($id)
    {
        $this->id = $id;
        $this->country_id = SalesChannels::find($id)->country->id;
        $user_id = Auth::guard('seller')->user()->id;
        $products = ProductSeller::where('seller_id', $user_id)->get();
        foreach ($products  as $product) {
            $this->products_ids[] = $product->id;
        }
    }

    public function model(array $row)
    {
        $order = Order::create([
            'sales_channel' => $this->id,
            'customer_name' => $row['customer_name'],
            'customer_phone1' => strval($row['customer_phone']),
            'customer_phone2' => strval($row['customer_phone']),
            'seller_notes' => $row['seller_notes'],
            'notes' => '',
            'status' => 0,
            'address' => $row['address'],
            'url' => $row['url'],
            'country_id' => $this->country_id
        ]);
        OrderProduct::create([
            'sales_channele_order' => $order->id,
            'product_id' => $row['product_id'],
            'amount' => $row['amount'],
            'price' => $row['total_price']
        ]);
        $user_id = Auth::guard('seller')->user()->id;
        $this->seller_id = $user_id;
        $this->ordeLog($user_id, $order->id, 0);

        return $order;
    }

    public function ordeLog($seller_id, $order_id, $status)
    {
        $log = OrderLog::create([
            'seller_id' => $seller_id,
            'order_id' => $order_id,
            'status' => $status
        ]);
        if ($log) {
            return 1;
        } else {
            return 2;
        }
    }

    public function rules(): array
    {
        $array = $this->products_ids;
        return [
            'customer_name' => ['required'],
            'customer_phone' => ['required', 'min:8'],
            'product_id' => [
                'required',
                Rule::in($array),
            ],
            'total_price' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'url' => ['required']
        ];
    }
}
