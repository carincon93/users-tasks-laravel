<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use App\Tasks\TaskResource;

#[TaskResource(TaskResource::class)]
class Task extends Model
{
    use HasFactory, HasUuids;

    /** Disable timestamps */
    public $timestamps = false;

    /** Set key type to string */
    protected $keyType = 'string';

    /** Disable auto-incrementing */
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'completed',
    ];

    protected $casts = [
        'id' => 'string',
        'completed' => 'boolean',
    ];

    /**
     * Get the Eloquent relationship for the task's user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
