<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionType extends Model
{
    protected $fillable = ['title'];

    public function sectionElements()
    {
        return $this->hasMany(SectionElement::class);
    }
}
