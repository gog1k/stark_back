<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 * @property bool $active
 * @property int $project_id
 * @property string $name
 * @property string $code
 * @property array $fields
 */
class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'project_id',
        'name',
        'code',
        'count',
        'fields',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'active' => 'bool',
        'count' => 'integer',
        'fields' => 'json'
    ];

    protected $attributes = [
        'fields' => '{}',
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(
            Project::class,
        );
    }

    /**
     * @return BelongsToMany
     */
    public function stats(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
        )
            ->withPivot('count')
            ->withPivot('fields')
            ->withTimestamps();
    }
}
