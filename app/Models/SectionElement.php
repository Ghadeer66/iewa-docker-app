<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionElement extends Model
{
    public function sectionElementImage()
    {
        return $this->belongsTo(Image::class, 'img_id');
    }
}
