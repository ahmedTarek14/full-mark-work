<?php

namespace Modules\Type\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Course\Entities\Course;
use Modules\University\Entities\University;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'university_id', 'faculty_name'];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }


    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
