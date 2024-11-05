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

    public function search(Request $request)
    {
        $tasks = self::query()
            ->when(
                $request->search,
                function (Builder $builder) use ($request) {
                    $builder->where('title', 'like', "%{$request->search}%");
                }
            )->get();

        return view('tasks.index', compact('tasks'));
    }

    public function filter(Request $request)
    {
        $filterText = $request->query('filter');
        $tasks = self::where('priority', 'like', '%' . $filterText . '%')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
