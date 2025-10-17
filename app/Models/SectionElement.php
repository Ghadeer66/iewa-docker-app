<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionElement extends Model
{
    protected $fillable = ['title', 'img_id', 'section_type_id'];

    public function sectionElementImage()
    {
        return $this->belongsTo(Image::class, 'img_id');
    }

    public function sectionType()
    {
        return $this->belongsTo(SectionType::class, 'section_type_id');
    }
}
