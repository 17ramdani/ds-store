<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Point\Point;
use App\Models\Point\DetailPointReedem;
use App\Models\Point\PointReedem;
use App\Models\Point\Merchant;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    public function index()
    {
        $custId     = auth()->user()->id;
        $data['total_point'] = Point::where('customer_id', $custId)->sum('point_total');
        $data['point_cust'] = Point::get()->where('customer_id', $custId);
        $data['customer']   = Customer::get()->where('id', $custId);

        return view('point.index', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function tukar()
    {
        $custId     = auth()->user()->id;
        $data['total_point'] = Point::where('customer_id', $custId)->sum('point_total');
        $data['merchant']   = Merchant::get();
        return view('point.tukar', $data);
    }

    public function count_tukarpoint(){
        $tanggal_now = date("Y-m-d");
        
        return json_encode(array(
            "statusCode" => $tanggal_now,
        ));
    }

    public function store(Request $request)
    {
        // DetailPointReedem::create([
        //     'redeem_point_id'       => 1,
        //     'voucher_point_id'      => $request->merchant_id,
        //     'point_spend'           => $request->total_amb,
        // ]);
        // PointReedem::create([
        //     'redeem_proposal_date'  => date('Y-m-d'),
        //     'customer_id'           => $request->customer_id,
        //     'redeem_date'           => date('Y-m-d'),
        //     'customer_service_id'   => 1,
        //     'total_redeem_spend'    => $request->total_amb,
        // ]);
        return json_encode(array(
            "statusCode" => 200
        ));
    }
}
