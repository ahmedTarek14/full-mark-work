<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auth\Entities\User;
use Modules\Type\Entities\Type;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'link'];

    /**
     * return restaurant users
     *
     * @return BelongsToMany
     */

    public function usersPivot(): HasMany
    {
        return $this->hasMany(CourseUser::class);
    }

    /**
     * return parent class
     *
     * @return BelongsTo
     */
    public function class (): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

}
