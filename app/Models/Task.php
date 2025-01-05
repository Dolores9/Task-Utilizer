<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Task extends Model
{
    use HasFactory;



    protected $fillable = [
        'title',
        'description',
        'completed',
        'due_date',
        'priority',
        'notes',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
