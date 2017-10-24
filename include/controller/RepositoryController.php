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

        # もしログインしていなければ
        if ( $this->authCheck() === false ) {
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

        # POSTアクセスかどうかを調べる
        if ( $this->isPost()=== true ) {
            # POSTアクセスなら、POST用のコントローラを実行
            $this->run_post();
            exit;
        }

        # リポジトリのIDを取得
        $repository_id = $this->getGet('id');

        # リポジトリIDが設定されていない、または、リポジトリIDが数値でなければエラー
        if ( empty($repository_id) === true || ctype_digit($repository_id) !== true ) {
            # 弾く
            $this->errorMsgs[] = '正常なリポジトリのIDが渡されていません';
            include_once(INCLUDE_PATH . '/include/view/errorView.php');
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
            include_once(INCLUDE_PATH . '/include/view/errorView.php');
            exit;
        }

        # ビューに渡すデータ群
        $this->params['repository_id'] = $repository_id;                                            # リポジトリのID
        $this->params['file_list'] = $repository->getFileList($repository_id);                      # ファイルリストのデータ
        $this->params['user_id'] = $user_id;                                                        # ユーザID

        # 読み込むビューを分けるために、ページモードを取得
        $page = $this->getGet('page');

        # 取得したページによって、処理をかえる
        if ( $page === 'setting' ) {

            # 管理者(1)か、マネージャー(2)でないと管理ページへ行けないのでその確認
            if ( $user_permission !== 1 && $user_permission !== 2 ) {
                # 権限が足りないのでエラー
                $this->errorMsgs[] = 'アナタの権限ではこのページを表示することはできません';
                include_once(INCLUDE_PATH . '/include/view/errorView.php');
                exit;
            }

            # リポジトリの設定ページ
            $this->repositorySetting($repository_id);

            # 処理の終了（これ以降の処理に流れないように）
            exit;

        } else if ( $page === 'delete' ) {

            # 削除対象のユーザを取得
            $delete_user_id = $this->getGet('delete_user_id');

            # 削除対象ユーザがなければエラー
            if ( $delete_user_id === '' ) {
                $this->errorMsgs[] = '削除するユーザIDを指定してください';
                include_once(INCLUDE_PATH . '/include/view/errorView.php');
                exit;
            }

            # リポジトリのアサインユーザを消す
            $this->deleteUserById($delete_user_id, $repository_id);

            # 処理の終了（これ以降の処理に流れないように）
            exit;

        }



        # ファイル一覧
        include_once(INCLUDE_PATH . '/include/view/repositoryView.php');

    }



    /**
     * POSTアクセスしたときはこちらの処理に移る
     *
     * @author Nな人<nnahito>
     * @return viod
     */
    public function run_post() {

        # リポジトリのIDを取得
        $repository_id = $this->getPost('id');

        # リポジトリIDが設定されていない、または、リポジトリIDが数値でなければエラー
        if ( empty($repository_id) === true || ctype_digit($repository_id) !== true ) {
            # 弾く
            $this->errorMsgs[] = '正常なリポジトリのIDが渡されていません';
            include_once(INCLUDE_PATH . '/include/view/errorView.php');
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
            $this->errorMsgs[] = 'この処理へのアクセス権がありません';
            include_once(INCLUDE_PATH . '/include/view/errorView.php');
            exit;
        }

        # 読み込むビューを分けるために、ページモードを取得
        $post = $this->getPost('page');

        # 取得したページによって、処理をかえる
        if ( $post === 'add' ) {

            # 追加ユーザのIDを取得
            $add_user_id = $this->getPost('add_user_id');

            # ユーザIDがなければエラー
            if ( $add_user_id === '' ) {
                $this->errorMsgs[] = '追加するユーザIDを指定してください';
                include_once(INCLUDE_PATH . '/include/view/errorView.php');
                exit;
            }

            # データを追加
            $repository->insertAssignedUser($add_user_id, $repository_id);

            # リポジトリの設定ページ
            $this->repositorySetting($repository_id);

            # 処理の終了（これ以降の処理に流れないように）
            exit;

        }

    }



    /**
     * リポジトリの設定ページを表示させる
     *
     * @author Nな人<nnahito>
     * @param  int    $repository_id    リポジトリのID（バリデーションチェック後のものを渡す）
     * @return void
     */
    private function repositorySetting(int $repository_id) {

        # リポジトリを操作するDAOをインスタンス化
        $repository = new Repository();

        # アサインされているユーザ一覧を取得
        $assigned_users = $repository->getAssignedUsers($repository_id);

        # ユーザ情報を扱うDAOをインスタンス化
        $user = new User();

        # すべてのユーザを取得
        $all_users = $user->getUsersList();

        # ビューに渡すデータ
        $this->params['assigned_users'] = $assigned_users;
        $this->params['all_users'] = $all_users;
        $this->params['repository_id'] = $repository_id;

        # ビューの読み込み
        include_once(INCLUDE_PATH . '/include/view/repositorySettingView.php');

    }



    private function deleteUserById(int $user_id, int $repository_id) {

        # ユーザの属性を取得するクラスをインスタンス化
        $user = new User();

        # ユーザの権限を取得
        $user_permission = $user->getUserPermission($user_id);

        # 管理者(1)か、マネージャー(2)でないと削除ができないので、その確認
        if ( $user_permission !== 1 && $user_permission !== 2 ) {
            # 権限が足りないのでエラー
            $this->errorMsgs[] = 'アナタの権限では削除を行うことができません';
            include_once(INCLUDE_PATH . '/include/view/errorView.php');
            exit;
        }

        # リポジトリを操作するDAOをインスタンス化
        $repository = new Repository();

        # ユーザIDを指定リポジトリから削除する
        $result = $repository->deleteUser($user_id, $repository_id);

        # 設定ページへ戻す
        $this->repositorySetting($repository_id);

    }

}
