<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterContest extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_hp',
        'enemy_hp',
        'hero_id',
        'enemy_id',
        'contest_id',
    ];

    public function hero() :BelongsTo
    {
        return $this->belongsTo(Character::class, 'hero_id', 'id');
    }

    public function enemy() :BelongsTo
    {
        return $this->belongsTo(Character::class, 'enemy_id', 'id');
    }

    public function contest():BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }


}
