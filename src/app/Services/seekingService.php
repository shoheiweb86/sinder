<?php
namespace App\Services;


use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Exception;

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
        error_log('アップロードエラー: ' . $e->getMessage());
    }
  }
}