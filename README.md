# アプリケーション名

勤怠管理システム（Atte（アット））<br>

概要説明（どんなアプリか）<br>
*勤怠管理システムであり、打刻ページで勤務の開始終了時刻や勤務時間、休憩時間を管理し、日付別やユーザーごとに勤怠の状況を確認できるアプリ<br>

*![alt text](初級模擬案件トップ画面.png)

## 作成した目的

概要説明（なんで作成したか）<br>
*とある企業から人事評価のために勤怠管理システムを作成して欲しいと依頼があったため。<br>

## アプリケーションURL

*http://ec2-54-65-234-135.ap-northeast-1.compute.amazonaws.com/<br>

*新規にユーザー登録し、ログインする時はメール認証が必要になるため、以下URLにアクセスし、メール認証を行ってください。上手くいかない場合は、一番下のテストユーザーを使用してください。<br>
*http://ec2-54-65-234-135.ap-northeast-1.compute.amazonaws.com:8025/<br>

上記URLにアクセスしても表示されない場合、私にお申し付けください。<br>

## 機能一覧

*・会員登録機能<br>
*・ログイン機能<br>
*・ログアウト機能<br>
*・メールでの本人確認機能<br>
*・勤務開始機能<br>
*・勤務終了機能<br>
*・休憩開始機能<br>
*・休憩終了機能<br>
*・日付別勤怠情報取得機能<br>
*・ユーザー一覧情報取得機能<br>
*・ユーザーごとの勤怠情報取得機能<br>
*・ページネーション機能<br>

## 使用技術（実行環境）

*・PHP 7.4.9<br>
*・Laravel 8<br>
*・MySQL 8.0.26<br>

## テーブル設計

*![alt text](初級模擬案件テーブル設計図-2.png)

## ER図

*![alt text](初級模擬案件ER図.png)

# 環境構築

*Dockerビルド<br>
*1.git clone リンク<br>
*2.DockerDesktopアプリを立ち上げる<br>
*3.docker-compose up -d --build<br>

*MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

*Laravel環境構築

*1.docker-compose exec php bash<br>
*2.composer install<br>
*3.env.exampleファイルから.envを作成し、環境変数を変更<br>
*4.php artisan key:generate<br>
*5.php artisan migrate<br>
*+α.php artisan db:seed（※ダミーデータを入れたい場合はこのコマンドを打ってください。）<br>

## URL

*開発環境:http://localhost/<br>
*phpMyAdmin:http://localhost:8080/<br>
*MailHog:http://localhost:8025/<br>

## アカウントの種類（テストユーザー）

*メールアドレス：test@example1.com<br>
*パスワード：testtesttest<br>

*ローカル環境ではダミーデータを入れないとこのアカウントは使えません。<br>