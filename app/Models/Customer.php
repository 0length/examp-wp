<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'born_date', 'born_place', 'gender', 'address', 'ktp_path'];

    public static function getAllCustomers() {
        $customers = DB::select("SELECT 
                                c.*,
                                u.name,
                                u.email
                                FROM customers c
                                JOIN users u ON u.id = c.user_id");

        return $customers;
    }

    public static function getCustomerDetails($customer_id) {
        $customers = DB::select("SELECT 
                                c.*,
                                u.name,
                                u.email
                                FROM customers c
                                JOIN users u ON u.id = c.user_id
                                WHERE c.id = ? ", [$customer_id]);

        return $customers[0];
    }
}
