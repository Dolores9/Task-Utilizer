<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'created_at'];


    public static function countDistinctLoginDays($userId)
    {
        return self::where('user_id', $userId)
            ->selectRaw('DATE() as date')
            ->groupBy('date')
            ->count();
    }




}
