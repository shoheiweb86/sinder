<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

