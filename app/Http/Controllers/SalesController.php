<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function buy(Request $request)
    {
        $input  = json_decode(json_encode($request->all()), true);
        $resultArray = array_filter($input, function ($key) use ($input) {
            return strpos($key, 'id_item-') === 0 && $input[$key];
        }, ARRAY_FILTER_USE_KEY);

        // dd($input, $resultArray, $request->all());

        if (count($resultArray)) {
            $dt = date("Y-m-d");
            $transDate = date("Y-m-d", strtotime("$dt +7 day"));
            $sales = Sales::create([
                'user_id' => $request->user()->id,
                'TransCode' => uniqid(),
                'TransDate' => $transDate,
            ]);

            foreach ($resultArray as $item_id => $qty){
                $orders = \DB::table('transaksi_detail')->insert([
                    'TransID' => $sales->id,
                    'BookID' => explode('id_item-', $item_id)[1],
                    'Qty' => 1,
                ]);

                $item = \DB::table('items')
                ->where(["id" => explode('id_item-', $item_id)[1]])
                ->first();

                \DB::table('items')
                ->where(["id" => explode('id_item-', $item_id)[1]])
                ->update([
                    "Stock" => $item->Stock - $qty
                ]);
            }
        }
        return redirect(route('sales'));
    }

    /**
     * Display a listing of the resource.
     */
    public function undone(Request $request)
    {
        $sales = null;
        if ($request->user()->roles == User::getRoleCustomer()) {
            $sales = Sales::getAllSalesUser($request->user()->id);
        } else {
            $sales = Sales::getAllSales();
        }
        $sales =  $sales->filter(function ($item) {
            return ($item->ReturnDate == null);
        });
        return view('sales.undone')->with('sales', $sales);
    }


    public function index(Request $request)
    {
        $lateReturnPercentage = Sales::getLateReturnPercentage();
        $mostTrendBook = Sales::getMostTrendBook();

        $sales = null;

        // Retrieve start_date and end_date from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Check if user is a customer
        if ($request->user()->role == User::getRoleCustomer()) {
            if ($startDate && $endDate) {
                // Retrieve filtered sales for the customer with date range
                $sales = Sales::getFilteredSalesUser($request->user()->id, $startDate, $endDate);
            } else {
                // Retrieve all sales for the customer
                $sales = Sales::getAllSalesUser($request->user()->id);
            }
        } else {
            if ($startDate && $endDate) {
                // Retrieve filtered all sales with date range
                $sales = Sales::getFilteredSales($startDate, $endDate);
            } else {
                // Retrieve all sales
                $sales = Sales::getAllSales();
            }
        }

        // dd($mostTrendBook);

        return view('sales.index',  compact('lateReturnPercentage', 'mostTrendBook'))->with('sales', $sales);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sales, $id)
    {
        $items = Sales::getSale($id);
        foreach ($items->orders as $key => $val) {
            $items->orders[$key] = (object) array_merge((array) $items->orders[$key], (array) $items->orders[$key]->items);
        }
        // dd($items);
        return view('sales.show')->with('sales', $items);
    }


    /**
     * Submit the specified resource.
     */
    public function submit(Request $request, $id)
    {
        $trans = Sales::find($id);
        $items =  \DB::table('transaksi_detail')
            ->where(["TransID" => $trans->id])
            ->get();

        $fineTotal = 0;
        foreach( $items as $item){

            $item->ReturnDate = date("Y-m-d");
            $diff = strtotime($item->ReturnDate) - strtotime($trans->TransDate);
            $daysDifference = floor($diff / (60 * 60 * 24));
            $item->FineDays =  $item->ReturnDate > $trans->TransDate ? $daysDifference : 0;
            $item->Fine =  $item->FineDays >10? 120000:$item->FineDays * 10000;
            
            \DB::table('transaksi_detail')
            ->where(["id" => $item->id])
            ->update(json_decode(json_encode($item), true));
            $fineTotal = $fineTotal + $item->Fine;
        }
        $trans->FineTotal = $fineTotal;
        $trans->update();
        $salesorders = (Sales::getSale($id))->orders;
        // dd($salesorders);
        foreach($salesorders as $order) {
            $old = \DB::table('items')
            ->where(["id" => $order->BookID])
            ->get();
            \DB::table('items')
                ->where(["id" => $order->BookID])
                ->update([
                    "Stock" => $old[0]->Stock + $order->Qty
                ]);
        }
        // dd($items);
        return redirect(route('sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
