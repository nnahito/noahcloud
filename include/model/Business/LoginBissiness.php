<?php
/**
 * ログイン周りを司るビジネスモデル
 */

Class LoginBissiness
{
    /**
     * アプリケーションクラスをインスタンス化したもの
     * @var $_app
     */
    private $_app;

    /**
     * コンストラクタ
     */
    public function __construct() {
        # アプリケーションクラスをインスタンス化
        $this->_app = new Application();
    }



    /**
     * ログインしているかどうかをセッションから確認し、
     * ログインしていたらtrue、ログインしていなければfalseを返す
     *
     * @author Nな人<nnahito>
     * @return boolean ログインしていたらtrue、ログインしていなければfalseを返す
     */
    public function isLogin() {
        # セッションインスタンスを取得
        $session = $this->_app->getSession();

        # ログインしているかどうかのセッションを参照
        $is_login = $session->get('USER_ID');

        # ログインしていなければ
        if ( $is_login === null ) {
            # falseを返す
            return (boolean)false;
        }

        # ログインしていればtrueを返す
        return (boolean)true;
    }



    /**
     * セッションを削除してログアウトさせます
     *
     * @author Nな人<nnahito>
     * @return viod
     */
    public function logout(int $user_id=null) {
        # セッションインスタンスを取得
        $session = $this->_app->getSession();

        # セッションそのものをすべて削除する
        $session->clear();

        # セッションからUSERIDを削除
        $session->remove('USER_ID');

        # ページ強制切り替え（あえての一度indexに飛ばす）
        header('Location: ./');
    }

}
