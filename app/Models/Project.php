<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'api_key',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'laravel_through_key',
        'api_key',
    ];

    /**
     * @retrn BelongsToMany
     */
    public function getAuthIdentifier(): int
    {
        return $this->id;
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($project) {
            if (empty($project->api_key)) {
                $project->api_key = Str::uuid()->toString();
            }
        });
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
        );
    }

    /**
     * @return HasMany
     */
    public function roomItems(): HasMany
    {
        return $this->hasMany(
            RoomItem::class,
        );
    }

    /**
     */
    public function roomItemTemplates()
    {
        return $this->roomItems()->roomItemTemplates;
    }
}
