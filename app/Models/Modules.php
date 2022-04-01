<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;

    public $table = 'modules';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'module_name',
        'parent_id'
    ];

    protected $appends = ['parent_module_name'];

    public function getParentModuleNameAttribute()
    { 
        return Modules::where('id', $this->parent_id)->pluck('module_name')->first();
    }

    public function children()
    {
        return $this->hasMany('App\Models\Modules', 'parent_id', 'id')->select(array('id', 'module_name as name', 'parent_id'))->orderBy('id', 'asc')->with('children');
    }

    
}
