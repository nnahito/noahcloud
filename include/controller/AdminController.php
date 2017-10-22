<?php

/**
* 管理者ページを制御するコントローラー
*/
class AdminController extends Controller
{

    /**
    * Applicationクラスを保存しておく変数
    * @var Application
    */
    private $_app;


    /**
     * ユーザIDを保存しておく変数
     * @var int ユーザIDが入る
     */
    private $_user_id;



    /**
    * コンストラクタ
    * いつもここからはじまるのさ
    *
    * @method __construct
    * @author Nな人<nnahito>
    */
    public function __construct() {

        # Applicationクラスをインスタンス化
        $this->_app = new Application();

        # Userのデータを扱うDAOをインスタンス化
        $userDao = new User();

        # セッションインスタンスを取得
        $session = $this->_app->getSession();

        # USERIDをセッションから取得
        $this->_user_id = $session->get('USER_ID');

        # 通常ユーザとしてログインしているかを確認
        if ( $this->authCheck() !== true ) {
            # ログインしていなければさようなら
            header('Location: ./login.php');
            exit;
        }

    }



    /**
    * コントローラーで一番最初にアクセスする場所
    * 下手したら、コントローラーというか、ルータの役割かも知れない
    *
    * @method run
    * @author Nな人<nnahito>
    * @return void
    */
    public function run() {

        # 飛んできたモードによって表示するページを振り分けるためのモードを取得
        $mode = $this->getGet('mode');

        # 取得したmodeによって実行するコントローラーを分ける
        if ( $mode === 'user' ) {
            # ユーザ管理の場合で、POST通信できた場合

        } else if ( $mode === 'ripository' ) {
            # リポジトリ管理の場合

        }


        # モードの引数が与えられていなければ、自分自身のプロフィール設定ページをロード
        # POSTアクセス可GETアクセスかでも処理が変わってくるので、POSTアクセスかどうかを見る
        if ( $this->isPost() === true ) {
            # POSTアクセスの時はプロフィールの更新用コントローラを実行
            $this->run_profile_post();
        } else {
            # GETアクセスの時は更新用のフォームを出す
            $this->run_profile();
        }

    }



    /**
     * ユーザのプロフィール情報を更新するフォームを出力します（GETアクセスの時）
     *
     * @method run_profile
     * @author Nな人<nnahito>
     * @return void
     */
    public function run_profile() {

        # Userのデータを扱うDAOをインスタンス化
        $userDao = new User();

        # 権限を確認（permission = 1 以外はプロフィールの変更しかできない）
        $this->params['permission'] = (int)$userDao->getUserPermission($this->_user_id);

        # 権限が取得できなければエラー
        if ( empty($this->params['permission']) === 0 ){
            # エラーページへ飛ばす
            $this->errorMsgs[] = '権限の取得に失敗しました。';
            include_once('../include/view/errorView.php');
            exit;
        }

        # ユーザ情報を取得する
        $this->params['user_info'] = $userDao->getUserInfoById($this->_user_id);

        # ビューへ
        include_once('../include/view/admin/indexView.php');

    }



    /**
     * ユーザのプロフィール情報を更新します(POSTアクセスの時)
     *
     * @method run_profile_post
     * @author Nな人<nnahito>
     * @return void
     */
    public function run_profile_post() {

        # Userのデータを扱うDAOをインスタンス化
        $userDao = new User();

        # 権限を確認
        $this->params['permission'] = (int)$userDao->getUserPermission($this->_user_id);

        # 権限が取得できなければエラー
        if ( empty($this->params['permission']) === 0 ){
            # エラーページへ飛ばす
            $this->errorMsgs[] = '権限の取得に失敗しました。';
            include_once('../include/view/errorView.php');
            exit;
        }

        # 送られてきたユーザIDを取得
        $form_user_id = $this->getPost('user_id');

        # 送られてきたユーザIDと、セッションのユーザIDを比べる
        if ( (int)$form_user_id !== (int)$this->_user_id ) {
            # もし、値が違うならエラー
            $this->errorMsgs[] = 'ユーザ情報に致命的な差異があります';
            include_once('../include/view/errorView.php');
            exit;
        }

        # 送られてきたフォームのデータをすべて取得
        $form_user_name = $this->getPost('user_name');          // ユーザ名
        $form_email = $this->getPost('email');                  // メールアドレス
        $form_password = $this->getPost('password');            // パスワード

        # もしパスワードが空なら
        if ( $form_password === '' ) {
            # 古いパスワードを利用する
            $form_password = $userDao->getUserInfoById($this->_user_id)['password'];
        }

        # 更新する情報を一つの入れに連想配列としてまとめる
        $update_data = [
            'user_id' => $form_user_id
            , 'user_name' => $form_user_name
            , 'email' => $form_email
            , 'password' => $form_password
        ];

        # アップデートを実行
        $stmt = $userDao->updateUserData($this->_user_id, $update_data);

        # フォームのページを表示
        $this->run_profile();

    }



    /**
     * ユーザ情報の設定ページに遷移します（GETアクセスの時）
     *
     * @method run_user_setting
     * @author Nな人<nnahito>
     * @return void
     */
    public function run_user_setting() {

        # Userのデータを扱うDAOをインスタンス化
        $userDao = new User();

        # 権限を確認（permission = 1 以外はプロフィールの変更しかできない）
        $this->params['permission'] = (int)$userDao->getUserPermission($this->_user_id);

        # 権限が管理者（permission = 1）ではない時
        if ( $this->params['permission'] !== 1 ) {
            # 権限不足でエラー
            $this->errorMsgs[] = 'このページにアクセするには権限が足りません';
            include_once('../include/view/errorView.php');
            exit;
        }

    }





}
