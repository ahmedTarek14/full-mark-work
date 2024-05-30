<?php

namespace Modules\Course\Entities;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auth\Entities\User;
use Modules\Type\Entities\Type;
use Modules\University\Entities\University;

class Course extends Model
{
    use HasFactory, ImageTrait;

    protected $fillable = ['name', 'type_id', 'pdf', 'default', 'university_id'];

    /**
     * return course users
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
    public function level(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function getPdfPathAttribute()
    {
        return $this->get_image($this->pdf, 'courses');
    }
}
