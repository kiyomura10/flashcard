# QuizMaker
 <img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/login.png">
 
 URL: <https://quizumaker.com>
 
 QuizMakerは自分でクイズを作成して学習ができるアプリです。

 ## 作成した理由
 
 プログラミングを勉強するなかで分からない専門用語がたくさん出てきたことがあります。専門用語について調べてもしばらく経つと忘れてしまうことが多く、どうにかして効率よく覚えられないかと思っていました。効率よく覚えるためには繰り返しアウトプット（想起）することが大事なので自分でクイズを作成して学習できるサービスを作成しました。

## 苦労したこと

### 非同期通信

最近はSPA構成で作られているアプリケーションも多いので、Ajax通信に興味がありました。最初は上手く通信ができなかったです。

### デプロイ

AWSや本番環境でアプリを動かすために必要な設定の知識が乏しかったのでかなり苦労しました。

## これからの課題
* データベース、学習記録のテーブル作成（問題を削除すると学習記録も消えるため）
* モチベーションを上げる機能機能（学習時間の記録、勉強した日の記録）
* 検索機能（クイズが増えてきた時に検索できる）、クイズの出題順の変更
* ui/ux,デザイン
* テストコード
* N+１問題
* リファクタリング
* CI/CD
 
## 機能一覧

### 認証

* ユーザー登録、表示、更新、削除
 
### クイズ管理

* 作成、表示、更新、削除
 
### タグ管理

* 作成、表示、更新、削除
* タグによる絞り込み
 
### 学習機能

* タグによるクイズの絞り込み
* 覚えていないクイズのみ出題
* 覚えたボタン
* ページネーション
* 解いた問題数、正解した問題数、覚えた問題数の表示

## 使用技術一覧

### フロントエンド
* HTML/TailwindCSS
* Vue.js

### バックエンド 

* PHP
* Laravel

### データベース  

* MySQL

### インフラ

* AWS(VPC,EC2,RDS)

## AWS(インフラ)構成図
<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/aws.png">

## 画面

### マイページ


<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/mypage.png">


### クイズ作成


<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/quizedit.png">


### クイズ一覧


<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/quizindex.png">


### タグ管理


<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/tag.png">


### 出題設定


<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/larnshow.png">


### 学習ページ


<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/larn.png">


## ER図

<img src="https://raw.githubusercontent.com/kiyomura10/flashcard/images/er.png">


