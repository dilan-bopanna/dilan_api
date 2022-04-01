<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $table = 'section';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'section_name',
        'parent_id'
    ];

    protected $appends = ['parent_name'];

    public function children()
    {
        return $this->hasMany('App\Models\Section', 'parent_id', 'id')->select(array('id', 'section_name as name', 'parent_id'))->orderBy('id', 'asc')->with('children');
    }

    public function getParentNameAttribute()
    { 
        return Section::where('id', $this->parent_id)->pluck('section_name')->first();
    }
}