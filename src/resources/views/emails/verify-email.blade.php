<!-- resources/views/emails/verify-email.blade.php -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレスの確認</title>
    <style>
      h1 {
        font-size: 30px;
      }
        /* ここにスタイルを追加します。 */
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }
        .button:hover {
            background-color: white;
            color: black;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body>

<h1>メールアドレスの確認</h1>

<p>アカウントを有効化するために以下のボタンをクリックしてください。</p>
<p>心当たりのない方は本メールを削除してください。</p>

<!-- ボタンをリンクとして実装 -->
<a href="{{ $url }}" class="button">アカウントを有効にして、Sinderに戻る</a>

<p>ご不明な点は下記のフォームよりお問い合わせください。</p>
<p><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSdUREB-SiESkcSvyt4ctKjP9wNdCrqF3YprEX-nf-VRdChJ9g/viewform">Sinderお問合せフォーム</a></p>

{{ config('app.name') }}</p>

</body>
</html>
