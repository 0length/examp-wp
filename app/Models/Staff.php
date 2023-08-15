<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'gender'];

    public static function getAllStaffs() {
        $staffs = DB::select("SELECT 
                                s.*,
                                u.name,
                                u.email
                                FROM staffs s
                                JOIN users u ON u.id = s.user_id");

        return $staffs;
    }

    public static function getStaffDetails($staff_id) {
        $staff = DB::select("SELECT 
                                s.*,
                                u.name,
                                u.email
                                FROM staffs s
                                JOIN users u ON u.id = s.user_id
                                WHERE s.id = ? ", [$staff_id]);

        return $staff[0];
    }
}
