<?php

namespace Modules\University\Entities;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Course\Entities\Course;
use Modules\Type\Entities\Type;

class University extends Model
{
    use HasFactory, ImageTrait;

    protected $fillable = ['name', 'logo'];


    public function levels(): HasMany
    {
        return $this->hasMany(Type::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function getLogoImagePathAttribute()
    {

        return $this->get_image($this->logo, 'universities');
    }
}
