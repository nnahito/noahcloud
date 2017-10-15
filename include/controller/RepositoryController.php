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

        # ログインをチェックする
        $login = new LoginBissiness();

        # もしログインしていなければ
        if ( $login->isLogin() === false ) {
            # ログインページへ飛ばす
            header('Location: ./login.php');
            exit;
        }

    }


    /**
     * すべての処理の始まり
     * @return void
     */
    public function run() {

        # リポジトリのIDを取得
        $repository_id = $this->getGet('id');

        # リポジトリIDが設定されていない、または、リポジトリIDが数値でなければエラー
        if ( empty($repository_id) === true || ctype_digit($repository_id) !== true ) {
            # 弾く
            $this->errorMsgs[] = '正常なリポジトリのIDが渡されていません';
            include_once('../include/view/errorView.php');
            exit;
        }

        # セッションを取得するインスタンスを取得
        $session = $this->app->getSession();

        # ユーザIDを取得
        $user_id = $session->get('USER_ID');

        # リポジトリを操作するDAOをインスタンス化
        $repository = new Repository();

        # ユーザの属性を取得するクラスをインスタンス化
        $user = new User();

        # ユーザにリポジトリの閲覧操作権が有るかを確認
        $permission = $repository->isAssigned($user_id, $repository_id);

        # ユーザの権限を取得
        $user_permission = $user->getUserPermission($user_id);

        # リポジトリへのアクセス許可リストにユーザIDがない、かつ、ユーザのパーミッションがマネージャ（1）でなければ
        if ( $permission !== true && $user_permission !== 1 ) {
            # 弾く
            $this->errorMsgs[] = 'このリポジトリへのアクセス権がありません';
            include_once('../include/view/errorView.php');
            exit;
        }


        # ビューに渡すデータ群
        $this->params['repository_id'] = $repository_id;                                            # リポジトリのID
        $this->params['file_list'] = $repository->getFileList($repository_id);                      # ファイルリストのデータ
        $this->params['user_id'] = $user_id;                                                        # ゆーざID 

        # ビューを読み込み
        include_once('../include/view/repositoryView.php');

    }

}
