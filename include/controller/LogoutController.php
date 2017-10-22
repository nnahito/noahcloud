<?php

Class LogoutController extends Controller
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

        # ログイン系を扱うクラスをインスタンス化
        $logout_bissiness = new LoginBissiness();

        # ログアウト
        $logout_bissiness->logout();

    }

}
