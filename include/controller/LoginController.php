<?php

/**
 * ユーザのログインを管理するコントローラー
 */
Class LoginController extends Controller
{
    /*
     * プロパティを定義する
     */
    private $app = '';                      # Applicationクラスを保持しておく変数

     /**
      * コンストラクタ
      */
    public function __construct() {
        # Applicationインスタンスを生成
        $this->app = new Application();
    }



    /**
     * すべての処理の始まり
     * @return void
    */
    public function run() {

        # POSTアクセスをしてきたら
        if ( $this->isPost() === true ) {
            # ログインチェック
            $this->checkLogin();
        }

        # Viewの表示
        include_once(INCLUDE_PATH . '/include/view/loginView.php');

    }



    /**
     * ログイン処理を行う
     */
    public function checkLogin() {
        # フォームからの値を受け取る（ユーザID）
        $email = $this->getPost('email');
        if ( $email === '' ) {
            $this->errorMsgs[] = 'ユーザIDが入力されていません';
        }

        # フォームからの値を受け取る（パスワード）
        $password = $this->getPost('password');
        if ( $password === '' ) {
            $this->errorMsgs[] = 'パスワードが入力されていません';
        }

        # エラーがなければ
        if ( count( $this->errorMsgs ) === 0 ) {
            # ユーザ情報を扱うDAOをインスタンス化
            $user_dao = new User();

            # DBから、ユーザIDとパスワードのセットを取得し、一致しているかを確かめる
            $user_info = $user_dao->getLoginInfo($email, $password);

            # ユーザ情報が存在していれば
            if ( $user_info !== false ) {
                # セッションにユーザ情報を書き込み、ログイン処理を行う
                $session = new Session();
                $session->set('USER_ID', $user_info['user_id']);

                # ログインに成功したらページを遷移する
                header('location: ./');

                return true;

            } else {
                # ユーザ情報がなければログイン失敗
                $this->errorMsgs[] = 'ログイン情報が間違っています';
            }

        }

        # ログイン失敗時
        return false;

    }

}
