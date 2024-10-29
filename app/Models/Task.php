<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'due_date',    // New column
        'priority',    // New column
    ];


    // You can add any additional methods here
    public function markAsCompleted()
    {
        $this->completed = true;
        $this->save();
    }

    public function markAsPending()
    {
        $this->completed = false;
        $this->save();
    }
}
