<?php

namespace App\Models;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Note extends Model 
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'notes';
    //protected $fillable = ['employer_id', 'title', 'salary'];
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, foreignPivotKey: 'note_id');
    }
    
}

