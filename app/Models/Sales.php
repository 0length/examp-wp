<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $fillable = ['TransCode', 'TransDate', 'FineTotal', 'user_id'];

    public static function getAllSales()
    {
        try {
            $sales = \DB::select("SELECT 
                                    s.*,
                                    u.name as customer_name
                                    FROM transaksi s
                                    JOIN users u ON u.id = s.user_id
                                   ");
            foreach ($sales as $key => $val) {
                // Retrieve orders for each sale
                $sales[$key]->orders = \DB::select("SELECT 
                    * FROM transaksi_detail WHERE TransID = ?", [$sales[$key]->id]);

                // Retrieve item details for each order
                if (count($sales[$key]->orders)) {
                    foreach ($sales[$key]->orders as $keyOrder => $val) {
                        $item = \DB::select("SELECT 
                            * FROM items WHERE id = ?", [$sales[$key]->orders[$keyOrder]->BookID]);
                        $sales[$key]->orders[$keyOrder]->items = count($item) ? $item[0] : (new stdClass());
                    }
                }
            }

            return $sales;
        } catch (\Throwable $th) {
            // dd($th);
            return [];
        }
    }

    public static function getSale($sales_id)
    {
        try {
            $sales = \DB::select("SELECT 
                                s.*,
                                u.name as customer_name
                                FROM transaksi s
                                JOIN users u ON u.id = s.user_id
                                WHERE s.id = ?", [$sales_id]);

            foreach ($sales as $key => $val) {
                // Retrieve orders for each sale
                $sales[$key]->orders = \DB::select("SELECT 
                    * FROM transaksi_detail WHERE TransId = ?", [$sales[$key]->id]);

                // Retrieve item details for each order
                if (count($sales[$key]->orders)) {
                    foreach ($sales[$key]->orders as $keyOrder => $val) {
                        $item = \DB::select("SELECT 
                            * FROM items WHERE id = ?", [$sales[$key]->orders[$keyOrder]->BookID]);
                        $sales[$key]->orders[$keyOrder]->items = count($item) ? $item[0] : (new stdClass());

                        // Retrieve and assign book type
                        $sales[$key]->orders[$keyOrder]->items->BookType = Item::getBookType($sales[$key]->orders[$keyOrder]->items->BookTypeID)->BookType;
                    }
                }
            }

            return $sales[0];
        } catch (\Throwable $th) {
            $customObject = new stdClass();
            $customObject->orders = [];
            return $customObject;
        }
    }

    public static function getAllSalesUser($userId)
    {
        try {
            $sales = \DB::select("SELECT 
                                    s.*,
                                    u.name as customer_name
                                    FROM transaksi s
                                    JOIN users u ON u.id = s.user_id
                                    WHERE s.user_id = ?", [$userId]);

            foreach ($sales as $key => $val) {
                // Retrieve orders for each sale
                $sales[$key]->orders = \DB::select("SELECT 
                    * FROM transaksi_detail  WHERE TransId = ?", [$sales[$key]->id]);

                // Retrieve item details for each order
                if (count($sales[$key]->orders)) {
                    foreach ($sales[$key]->orders as $keyOrder => $val) {
                        $item = \DB::select("SELECT 
                            * FROM items WHERE id = ?", [$sales[$key]->orders[$keyOrder]->BookID]);
                        $sales[$key]->orders[$keyOrder]->items = count($item) ? $item[0] : (new stdClass());
                    }
                }
            }

            return $sales;
        } catch (\Throwable $th) {
            // dd($th);
            return [];
        }
    }

    public static function getFilteredSales($startDate, $endDate)
    {
        try {
            $sales = \DB::select("SELECT 
                                    s.*,
                                    u.name as customer_name
                                    FROM transaksi s
                                    JOIN users u ON u.id = s.user_id
                                    WHERE s.created_at >= ? AND s.created_at <= ?", [$startDate, $endDate]);

            foreach ($sales as $key => $val) {
                // Retrieve orders for each sale
                $sales[$key]->orders = \DB::select("SELECT 
                    * FROM transaksi_detail WHERE TransID = ?", [$sales[$key]->id]);

                // Retrieve item details for each order
                if (count($sales[$key]->orders)) {
                    foreach ($sales[$key]->orders as $keyOrder => $val) {
                        $item = \DB::select("SELECT 
                            * FROM items WHERE id = ?", [$sales[$key]->orders[$keyOrder]->BookID]);
                        $sales[$key]->orders[$keyOrder]->items = count($item) ? $item[0] : (new stdClass());
                    }
                }
            }

            return $sales;
        } catch (\Throwable $th) {
            // dd($th);
            return [];
        }
    }

    public static function getFilteredSalesUser($userId, $startDate, $endDate)
    {
        try {
            $sales = \DB::select("SELECT 
                                    s.*,
                                    u.name as customer_name
                                    FROM transaksi s
                                    JOIN users u ON u.id = s.user_id
                                    WHERE s.user_id = ? AND s.created_at >= ? AND s.created_at <= ?", [$userId, $startDate, $endDate]);

            foreach ($sales as $key => $val) {
                // Retrieve orders for each sale
                $sales[$key]->orders = \DB::select("SELECT 
                    * FROM transaksi_detail WHERE TransID = ?", [$sales[$key]->id]);

                // Retrieve item details for each order
                if (count($sales[$key]->orders)) {
                    foreach ($sales[$key]->orders as $keyOrder => $val) {
                        $item = \DB::select("SELECT 
                            * FROM items WHERE id = ?", [$sales[$key]->orders[$keyOrder]->BookID]);
                        $sales[$key]->orders[$keyOrder]->items = count($item) ? $item[0] : (new stdClass());
                    }
                }
            }

            return $sales;
        } catch (\Throwable $th) {
            // dd($th);
            return [];
        }
    }

    public static function getLateReturnPercentage()
    {
        $totalSales = self::count();
        $lateReturns = self::whereIn('id', function ($query) {
            $query->select('TransId')
                ->from('transaksi_detail')
                ->whereColumn('ReturnDate', '>', 'TransDate');
        })->count();

        return ($totalSales > 0) ? ($lateReturns / $totalSales) * 100 : 0;
    }

    public static function getMostTrendBook()
    {
        $mostTrendBookId = \DB::table('transaksi_detail')
            ->select('BookID', \DB::raw('COUNT(*) as count'))
            ->groupBy('BookID')
            ->orderByDesc('count')
            ->value('BookID');

        return Item::find($mostTrendBookId);
    }
}