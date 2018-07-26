<?php

namespace Softce\Slider\Module;


use Illuminate\Database\Eloquent\Model;

class Priceua extends Model
{
    use \Themsaid\Multilingual\Translatable;

    protected $fillable = ['path', 'title', 'text', 'url'];
    public $translatable = ['title', 'text'];
    public $casts = [
        'title' => 'array',
        'text' => 'array'
    ];
}