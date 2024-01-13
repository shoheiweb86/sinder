<?php
namespace App\Services;

use App\Models\Like;
use App\Models\Seeking;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Auth;
class seekingService
{
  /**
   * 画像ファイルを圧縮して、webpに変換
   *
   * @param Illuminate\Http\UploadedFile $image_file 
   * @return Illuminate\Http\UploadedFile $compressed_image
   */
  public static function compressionImage($image_file) 
  {
    $compressed_image = Image::make($image_file)
      ->orientate() //向きが変わらないようにする
      ->resize(750, null, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
      })
      ->encode('webp')  // WebP形式に変換
      ->stream(); // 圧縮した画像のデータを取得

    return $compressed_image;
  }

  /**
   * S3に画像をアップロードする
   *
   * @param \Illuminate\Http\UploadedFile $image_file アップロードするファイル
   * @param string $folder_name s3に保存するフォルダ名
   * @param string $file_name s3に保存するファイル名
   * @return void
   */
  public static function uploadImageS3($image_file, $folder_name)  
  { 
    $file_name = time() . '.webp';
    try {
        // 画像をS3にアップロード
        Storage::disk('s3')->put($folder_name . '/' . $file_name, (string) $image_file);
    } catch (Exception $e) {
        error_log('s3への画像アップロードでエラーが起きました' . $e->getMessage());
    }
  }
  

  /**
   * S3の画像を削除
   *
   * @param string $folder_name "seeking_thumbnail" or "avatar"
   * @param string $file_name
   * @return void
   */
  public static function deleteImageS3($folder_name, $file_name)
  {
    try {
      //S3の画像を削除
      Storage::disk('s3')->delete($folder_name . '/' . $file_name);
    } catch (Exception $e) {
        error_log('s3の画像削除でエラーが起きました' . $e->getMessage());
    }
  }

  /**
   * 自分の募集かチェックする
   *
   * @param int $seeking_id
   * @param int $user_id
   * @return boolean
   */
  public static function checkMySeeking($seeking_id, $user_id)
  {
    $seeking = Seeking::findOrFail($seeking_id);

    //自分の募集かチェック
    if ($seeking->user->id == $user_id) {
      return true;
    }

    return false;
  }

  /**
   * 募集を作成したユーザーのidを取得
   *
   * @param int $seeking_id
   * @return int
   */
  public static function getCreatorUserId($seeking_id)
  {
    $seeking = Seeking::findOrFail($seeking_id);
    $user_id = $seeking->user_id;

    return $user_id;
  }
}