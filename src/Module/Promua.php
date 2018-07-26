<?php

namespace Softce\Promua\Module;


use Illuminate\Database\Eloquent\Model;

class Promua extends Model
{
    use \Themsaid\Multilingual\Translatable;

    protected $fillable = ['path', 'title', 'text', 'url'];
    public $translatable = ['title', 'text'];
    public $casts = [
        'title' => 'array',
        'text' => 'array'
    ];
}