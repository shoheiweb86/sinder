<?php


namespace App\Models;

use App\Http\Requests\SeekingRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        return $this->hasMany(Like::class, 'like_to_seeking_id');
    }

    /**
     * 新規作成した募集をDBに保存する
     *
     * @param SeekingRequest $request
     * @return void
     */
    public static function createSeeking(SeekingRequest $request)
    {
      $seeking = new Seeking;
      $seeking->user_id = Auth::id();
      $seeking->title = $request->title;
      $seeking->content = $request->content;

      //サムネイルのパスを保存する処理
      if ($request->hasFile('seeking_thumbnail')) {
        $seeking->seeking_thumbnail =  time() . '.webp';
      } else {
        $seeking->seeking_thumbnail = 'default-thumbnail.webp';
      }

      $seeking->save();
    }

    /**
     * 募集の情報を上書きする
     *
     * @param SeekingRequest $request
     * @param int $seeking_id
     * @return void
     */
    public static function updateSeeking(SeekingRequest $request, $seeking_id)
    {
      //idで特定の募集を取得する
      $seeking = Seeking::findOrFail($seeking_id);
      $seeking->title = $request->input('title');
      $seeking->content = $request->input('content');

      //サムネイルのパスを保存する処理
      if ($request->hasFile('seeking_thumbnail')) {
        $seeking->seeking_thumbnail =  time() . '.webp';
      } else {
        $seeking->seeking_thumbnail = 'default-thumbnail.webp';
      }

      $seeking->save();
    }

    /**
     * 相対時間を取得する
     *
     * @return string
     */
    public function formattedCreatedAt()
    {
        return $this->created_at->diffForHumans();
    }
}

