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

        # もしログインしていなければ
        if ( $this->authCheck() === false ) {
            # ログインページへ飛ばす
            header('Location: ./login.php');
            exit;
        }

    }




    /**
     * 必ずここが呼ばれる
     * @return void
     */
    public function run(){

        # まず、アクセスしてきた人がそのファイルをダウンロードする権限を持っているかを確認する
        $session = $this->app->getSession();                    # セッション系のモデルをインスタンス化
        $db = $this->app->getDatabase();                        # DBを扱うモデルをインスタンス化
        $login = new LoginBissiness();                          # ログイン周りを司るクラスをインスタンス化
        $repository = new Repository();                         # リポジトリの操作を行うDAOクラスをインスタンス化
        $user = new User();                                     # ユーザの操作を行うDAOクラスをインスタンス化

        # SESSIONからログイン中のユーザを取得する
        $user_id = $session->get('USER_ID');

        # ユーザIDがなければエラー
        if ( $user_id === null ) {
            # セッションを破棄してログアウト状態にする（ページも遷移させる）
            $login->logout();
            exit;
        }

        # GETアクセスで渡される、リポジトリIDを取得
        $repository_id = $this->getGet('repository_id');

        # リポジトリIDが設定されていない、または、リポジトリIDが数値でなければエラー
        if ( empty($repository_id) === true || ctype_digit($repository_id) !== true ) {
            # 弾く
            $this->errorMsgs[] = '正常なリポジトリのIDが渡されていません';
            include_once('../include/view/errorView.php');
            exit;
        }

        # リポジトリにそのユーザがアクセス権限を持っているかと、ユーザがマネージャー権限（1）を持っているかを確認
        if ( $repository->isAssigned($user_id, $repository_id) !== true && $user->getUserPermission($user_id) !== 1 ) {
            # アクセス権がなければエラー
            $this->errorMsgs[] = 'アクセス権がありません';
            include_once('../include/view/errorView.php');
            exit;
        }

        # ダウンロードするファイルIDを取得
        $file_id = $this->getGet('file_id');

        # ファイルIDが指定されていなければエラー
        if ( $file_id === '' ) {
            # エラーページを表示
            $this->errorMsgs[] = 'ファイルIDが指定されていません';
            include_once('../include/view/errorView.php');
            exit;
        }

        # ファイル名を取得
        $file_name = $repository->getFileNameById($file_id);

        # ファイル名がなければエラー
        if ( $file_name === false ) {
            # エラーページを表示
            $this->errorMsgs[] = 'ファイルIDが存在していません。削除された可能性があります';
            include_once('../include/view/errorView.php');
            exit;
        }

        # ファイル名は、「[file_list_id]_ファイル名」なので、そのように整形
        $filepath = './upfiles/' . $file_id . '_' . $file_name;

        # ファイルの大きさを取得
        header('Content-Length: '.filesize($filepath));

        # ファイル名を整形
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        # ダウンロードを実行
        readfile($filepath);

    }

}
