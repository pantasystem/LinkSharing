# Seederで生成するデータの仕様書
以下のモデルに対してSeederを作成する
- User
- Note
- Tag
- Favorite
- FollowingUser

また以下のモデルに対してはSeederは作成しない
- Comment
- Notification  
- Summary  

## User
ユーザーを作成するSeeder
ユーザーを作成する件数は100件作成することとする。
またフォローフォロワー関係についてはこのSeederは一切責務を負わない。

## Note
ノートのテスト用データを作成する作成パターン。  
全ユーザーに対して100件ずつノートを作成する。  
またユーザーのフォローフォロワー関係についてはこのSeederでは考慮しない。  
SummaryはNoteSeederから作成することとする。  
Summaryは本来Noteに属していてもおかしくない情報であるが、  
データと流れの都合上Noteと別で、  
NoteがSummaryの外部キーを持つNote：Summary=多：単になってしまっているが、  
イメージとしては１：１である。なのでSummaryは基本的にはIdで取得することはない。

## Tag
データベース中に存在するノートの件数nに対し  
タグの件数tで以下の条件の範囲内でランダムにノートにタグ付を行う  
ノートに対してのタグ数k
0 <= k < 10 かつ k < t
 

## Favorite
奇数idのユーザーは自分を除く全てのユーザーの投稿に対してFavoriteする。
また同時にNotificationも作成する。

## FollowingUser
 ユーザーのフォロー関係を保持するFollowingUserSeeder  
 各ユーザーは自分を除くDB中のユーザー全てをフォローするものとする。  
 つまりユーザーが全部で100件だとすれば9900件のレコードが作成されることとなる。  
 またNotificationの作成処理はしないこととする。  
 

## Comment
Commentは複数のCommentとNote複数のModelに従属することができ、様々なケースに対応することのできるデータを作成するのが難しいため、Seederでは作成しない。

## Notification
NotificationはNotificable可能なModelが作成されるときに発行されるものなので各種対応するSeederで作成することにした。

## Summary 
SummaryはEntityではなく、データ構造上でこそは、  
NoteはSummaryに対し関数従属をしているが、実際のモデルでは、SummaryはNoteの一部の要素でしかない。ため作成しない。
   