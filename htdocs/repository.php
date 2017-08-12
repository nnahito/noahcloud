<?php

class IndexController extends Controller{
    /* プロパティ定義エリア */
    private $app;               # Applicationインスタンスを保持しておく

    /**
     * コンストラクタ
     */
    public function __construct(){
        # Applicationインスタンスを生成
        $app = new Application();
    }


    /**
     * すべての処理の始まり
     * @return void
     */
    public function run(){
        # データベースからデータを取得
        $db = $app->getDatabase();

        # リポジトリの一覧を取得
        $this->params['repositories'] = $db->getFetchAll('select repository_id, repository_name from repository');

        # ビューを読み込み
        include_once('../include/view/indexView.php');
    }
}
