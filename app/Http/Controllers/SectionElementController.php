<?php

namespace App\Http\Controllers;

use App\Models\SectionElement;
use Illuminate\Http\Request;

class SectionElementController extends Controller
{
     public function index()
    {
        // Eager load the related image and type
        $elements = SectionElement::with(['sectionElementImage', 'sectionType'])->get();


        // Map to desired format for frontend
        $data = $elements->map(function ($el) {
            return [
                'title' => $el->title,
                'image' => $el->sectionElementImage?->url ?? '', // fallback if no image
                'alt' => $el->title, // or generate alt text differently
                'extra' => "Extra info for {$el->title}",
                'type' => $el->sectionType?->title,
            ];
        });



        return response()->json($data);
    }
}
