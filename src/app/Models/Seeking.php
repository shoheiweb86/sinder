<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\User;
class Seeking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'image'];

    //ユーザーへのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //気になるへのリレーション
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}

