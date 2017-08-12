<?php
class IndexController extends Controller{
    /**
     * すべての処理の始まり
     * @return void
     */
    public function run(){
        # データベースからデータを取得
        $db = Database::getInstance();

        # リポジトリの一覧を取得
        $this->params['repositories'] = $db->getFetchAll('select repository_id, repository_name from repository');

        # ビューを読み込み
        include_once('../include/view/indexView.php');
    }
}
