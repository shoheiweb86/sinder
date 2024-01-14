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
   * 相対時間を取得する
   *
   * @return string
   */
  public function formattedCreatedAt()
  {
    return $this->created_at->diffForHumans();
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
   * idで募集を取得
   *
   * @param int $seeking_id
   * @return Collection
   */
  public static function getSeekingById($seeking_id)
  {
    $seeking = Seeking::findOrFail($seeking_id);
    return $seeking;
  }

  /**
   * 募集を全て取得する 引数で性別を指定
   *
   * @param string $sex
   * @return Collection
   */
  public static function getSeekingsBySex($sex)
  {
    //クエリのベースを定義
    $query = Seeking::orderBy('created_at', 'desc');

    // 性別で取得
    if ($sex == 'man') {
      $query->whereHas('user', function ($query) use ($sex) {
          $query->where('sex', '男性');
      });
    } else if ($sex == 'woman') {
        $query->whereHas('user', function ($query) use ($sex) {
            $query->where('sex', '女性');
      });
    }

    //クエリ実行
    $seekings = $query->get();

    return $seekings;
  }

  /**
   * 募集を全て取得する 引数で性別を指定
   * likeとuserを紐づけて取得
   *
   * @param int $user_id
   * @param string $sex
   * @return Collection
   */
  public static function getSeekingsBySexWithLikesAndUser($user_id, $sex)
  {
    // クエリのベースを定義
    $query = Seeking::with(['likes' => function ($query) use ($user_id) {
        $query->where('like_from_user_id', $user_id);
    }])
    ->with('user')
    ->orderBy('created_at', 'desc');

    // 性別で取得
    if ($sex == 'man') {
      $query->whereHas('user', function ($query) use ($sex) {
        $query->where('sex', '男性');
      });
    } else if ($sex == 'woman') {
        $query->whereHas('user', function ($query) use ($sex) {
          $query->where('sex', '女性');
      });
    }
    // クエリを実行
    $seekings = $query->get();

    return $seekings;
  }

  /**
   * ユーザーがlikeした募集を取得 
   * likeとuserを紐づけて取得
   *
   * @param string $user_id
   * @return Collection
   */
  public static function getLikedSeekingsByUser($user_id)
  {
    $user_liked_seekings = Seeking::whereHas('likes', function ($query) use ($user_id) {
      $query->where('like_from_user_id', $user_id);
    })
    ->with('likes')
    ->with('user')
    ->get();

    return $user_liked_seekings;
  }

  /**
   * ユーザーのlikeされた募集を取得
   *
   * @param string $user_id
   * @return Collection
   */
  public static function getReceivedLikesSeekings($user_id)
  {
    //ユーザーの募集に絞る
    $received_likes_seekings = Seeking::where('user_id', $user_id)
      //ユーザーに対してlikeされた募集に絞り込み
      ->whereHas('likes', function ($query) use ($user_id) {
          $query->where('like_to_user_id', $user_id);
      })

      //likeしたユーザーを取得
      ->with(['likes' => function ($query) use ($user_id) {
        //ユーザーに対してlikeしているレコードに絞り込む
        $query->where('like_to_user_id', $user_id);
      }, 'likes.likes_from_users'])

      ->get();

    return $received_likes_seekings;
  }

  /**
   * マッチ済みの自分の募集を取得、マッチしたユーザーも紐づけて取得
   *
   * @param string $user_id
   * @return Collection
   */
  public static function getConnectedMySeekings($user_id) 
  {
    $connected_my_seekings = Seeking::where('user_id', $user_id)
      //ユーザーに対してlikeされた募集に絞り込み
      ->whereHas('likes', function ($query) use ($user_id) {
          $query->where('like_to_user_id', $user_id);
      })

      //likeしたユーザーを取得
      ->with(['likes' => function ($query) use ($user_id) {
        //ユーザーに対してlikeしているレコードに絞り込む
        $query->where('like_to_user_id', $user_id)
          ->where('connected_flag', 1);
      }, 'likes.likes_from_users'])

      ->get();

    return $connected_my_seekings;
  }

  /**
   * マッチ済みの他の人の募集を取得、マッチしたユーザーも紐づけて取得
   *
   * @param string $user_id
   * @return Collection
   */
  public static function getConnectedOthersSeekings($user_id) 
  {
    //他の人の募集に絞る
    $connected_others_seekings = Seeking::where('user_id', '!=', $user_id)
      //マッチしていて、ユーザーがlikeした募集に絞り込み
      ->whereHas('likes', function ($query) use ($user_id) {
          $query->where('like_from_user_id', $user_id)
            ->where('connected_flag', 1);
      })
      ->with('user')

      ->get();

    return $connected_others_seekings;
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
   * 募集をDBから削除
   *
   * @param int $seeking_id
   * @return void
   */
  public static function deleteSeeking($seeking_id)
  {
    //idで特定の募集を取得する
    $seeking = Seeking::findOrFail($seeking_id);

    $seeking->delete();
  }
}
