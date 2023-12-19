<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['like_from_user_id', 'like_to_user_id', 'like_to_seeking_id', 'connected_flag', 'connected_date'];

    // likeしたユーザーを取得
    public function likes_from_users()
    {
        return $this->belongsTo(User::class, 'like_from_user_id');
    }

    // likeされたユーザーを取得
    public function likes_to_users()
    {
        return $this->belongsTo(User::class, 'like_to_user_id');
    }

    // 募集へのリレーション
    public function seeking()
    {
        return $this->belongsTo(Seeking::class, 'like_to_seeking_id');
    }
}
