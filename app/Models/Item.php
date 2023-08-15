<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
 
class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $fillable = ['BookName', 'BookTypeID', 'Description', 'Publisher', 'Stock', 'Year'];
    
    
    public static function getBookType($id) {
       return Category::find($id); 

    }


    public static function summaryItemsSales() {
        $items = DB::select("SELECT 
                                i.`BookName`,
                                i.`Stock`,
                                i.`Publisher`,
                                i.`Year`,
                                SUM(o.`qty`) AS qty_total
                                FROM items i
                                JOIN transaksi_detail o ON o.`BookID` = i.`id`
                                JOIN transaksi s ON s.`id` = o.`TransId`
                                WHERE o.`ReturnDate` IS NOT NULL
                                GROUP BY i.`id`, i.`BookName`, i.`Stock`, i.`Publisher`, i.`Year`");

        return $items;
    }
}