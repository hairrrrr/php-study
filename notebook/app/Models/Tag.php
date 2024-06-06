<?php

namespace App\Models;

use App\Models\Node;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function note() 
    {
        // 默认查询外键名称为 tag_id
        return $this->belongsToMany(Note::class, relatedPivotKey: 'note_id');
    }
}
