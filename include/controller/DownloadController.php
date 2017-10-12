<?php

/**
 * アップロードされたファイルをダウンロードするときのアクセス処理をコントロールします
 */
Class DownloadController extends Controller{
    /*
     * プロパティ定義エリア
     */
    private $app;                                   # Applicationインスタンスを保持しておく

    /**
     * コンストラクタ
     */
    public function __construct(){
        # Applicationインスタンスを生成
        $this->app = new Application();
    }




    /**
     * 必ずここが呼ばれる
     * @return void
     */
    public function run(){
        # まず、アクセスしてきた人がそのファイルをダウンロードする権限を持っているかを確認する
        $session = $this->app->getSession();                    # セッション系のモデルをインスタンス化
        $db = $this->app->getDatabase();                        # DBを扱うモデルをインスタンス化

        # SESSIONからログイン中のユーザを取得する
        $user_id = $session->get('USER_ID');

        # DBからユーザの権限を確認する
        $user_dao = new User();
        

    }

}
