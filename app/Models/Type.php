<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort',
    ];

    public function animals()
    {
        // hasMany(类别名称, 参照栏位, 主键)
        return $this->hasMany('App\Models\Animal', 'type_id', 'id');
    }
}
