<?php

class RepositoryController extends Controller{
    /* プロパティ定義エリア */
    private $app;               # Applicationインスタンスを保持しておく

    /**
     * コンストラクタ
     */
    public function __construct(){
        # Applicationインスタンスを生成
        $this->app = new Application();
    }


    /**
     * すべての処理の始まり
     * @return void
     */
    public function run(){
        # リポジトリのIDを取得
        $repository_id = $this->getGet('id');
        $this->params['repository_id'] = $repository_id;

        # データベースからデータを取得
        $db = $this->app->getDatabase();

        # リポジトリのファイル一覧を取得
        $sql = '
        SELECT
            file_list_id, repository_id, file_name, upload_person, uploaded_at
        FROM
            file_list
        WHERE
            repository_id = :id
        ';
        $this->params['file_list'] = $db->getFetchAll($sql, ['id' => $repository_id]);

        # ビューを読み込み
        include_once('../include/view/repositoryView.php');
    }
}
