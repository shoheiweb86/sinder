## Sinder(シンダー)の提供する価値
新大生が求めている新大生をマッチングさせ、良い出会いを提供する<br>
新大生に大学生活を充実させてほしい！！

<br>

## サービスのURL
登録せずにアプリを閲覧できる機能があるので、新大生以外の方も覗いてみてください。

https://sinder.jp/
<br>
※スマホの画面幅のみ対応です

<br>

## サービスの想い
私の周りには、<br>
・彼女が居なくて困っている男友達<br>
・彼氏がいなくて困っている女友達<br>
が沢山いた。<br>
<br>
そんな友達に既存のマッチングアプリを勧めてみたが、「変な人がいるから登録するのが怖い」という意見が多かった。<br>
そこで、新大生限定のマッチングアプリにすれば、安心して健全な出会いを増やせるのではないかと考えた。<br>
<br>
恋愛だけでなく、<br>
・サークルの新歓<br>
・過去問の共有<br>
・バイトの募集<br>
などにも活用できるようなサービスにした。<br>
<br>
将来的には新大生の殆どがこのアプリを使っている状態になり、<br>
「新大生を募集するならシンダーでしょ！！」と言われるようなサービスにしたいと考えている。

<br>

## アプリケーションのイメージ
##### ↓掲載されている募集に「気になる」をする流れ
<img width="300px" src="https://github.com/shoheiweb86/sinder/assets/82988094/9150ef69-e93b-471a-9d0e-ec9981ab3a7f">
<br>

<br>

##### ↓「気になる」されたユーザーがマッチングをして、SNSを閲覧できるようになる流れ
<img width="300px" src="https://github.com/shoheiweb86/sinder/assets/82988094/a4e6c8d8-95bd-413d-bfea-eed1885f2783">
<br>

<br>

<!-- 
## 機能一覧
<img width="300px" src="https://github.com/shoheiweb86/sinder/assets/82988094/d9b865d3-c511-4a9e-8133-e02e7f26fbd1">
<img width="300px" src="https://github.com/shoheiweb86/sinder/assets/82988094/d72c4e06-5fcf-480e-8e36-f9cbcf53a0a9">
<img width="300px" src="https://github.com/shoheiweb86/sinder/assets/82988094/21f020b3-deaf-450b-9af9-fbae7c1e7949">
<br>

<br>

-->

## 使用技術

| Category          | Technology Stack                                     |
| ----------------- | --------------------------------------------------   |
| Frontend          | Blade, jQuery,TailwindCSS                            |
| Backend           | Laravel                                              |
| Infrastructure    | EC2, RDS, S3, Route53                                |
| Database          | MySQL                                                |
| Environment setup | Docker                                               |
| Design            | Figma                                                |
| etc.              | Git, GitHub                                          |

<br>

## ER図
<img width="700" alt="スクリーンショット 2023-10-28 17 11 48" src="https://github.com/shoheiweb86/sinder/assets/82988094/6a14ed8f-c96a-410c-acdd-19dffac6a395">

<br>

## 工夫した点

### ビジネスサイド
- チャット機能を省くことで、開発コスト削減した。<br>
既存のマッチングアプリは、マッチしたらアプリ内のチャット移行するものが多い。(身バレ防止のため)<br>
Sinderはマッチしたら登録しているSNSに移行するようにした。<br>
（元から新大生しか使っていないので、身バレを気にする必要がないため）<br>
- 登録するメールアドレスを、新潟大学生のみに配布されているメアドでバリデーションをかけることで、<br>
新潟大学生以外使用できないようにした。

<br>

### エンジニアサイド

- 開発環境にDockerを使用して、ローカル環境に依存せずに開発した。 <br>
インフラにAWS（EC2, RDS, S3, Route53）を使用することで、セキリティやスケーラビリティを考慮して運用できるようにした。<br>
- 募集に対して「気になる」を押した時の処理を、非同期処理で実装した。<br>
非同期処理で実装することで、サーバーの負荷改善やUXの向上させている。

<br>

## 今後の展望
- 実際に新大生に使ってもらい、FBを元に改善する
- WebPush通知またはLINE Notifyを使用し、通知機能を実装する
- フロントエンドをReactまたはVueでリプレイスする
- 新規登録した際に、簡単なアプリの説明を表示する
- etc.....<br>
**新大生の出会いに貢献する！！！**
