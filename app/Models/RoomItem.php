<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property boolean $active
 * @property string $name
 * @property string $type
 */
class RoomItem extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'type',
        'name',
        'project_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'laravel_through_key'
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
     * @return HasManyThrough
     */
    public function roomItemTemplates(): HasManyThrough
    {
        return $this->hasManyThrough(
            ItemTemplate::class,
            RoomItemTemplate::class,
            'room_item_id',
            'id',
            'id',
            'item_template_id'
        );
    }

    public function roomItemTemplatesIds()
    {
        return $this->roomItemTemplates->pluck('id');
    }
}
