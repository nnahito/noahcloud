<?php

/**
 * バリデーションを行う処理をまとめておくクラス
 */
Class Validate{
    /* プロパティ定義エリア */
    private $app = '';              # Applicationクラスのインスタンス用

    /**
     * コンストラクタ
     */
    public function __construct(){
        # Applicationクラスをインスタンス化
        $this->app = new Application();
    }



    private function validPassword($user_id, $password){
        # DBからユーザのリストを取得する
        $db = $this->app->getDatabase();
        $rows = $db->getFetch('select user_id, password, permission from user where user_id = :user_id', ['user_id' => $user_id]);

        var_dump($rows);
        exit();

        # ユーザIDがなければ
        if ( $rows->user_id === '' ){

        }


    }
}
