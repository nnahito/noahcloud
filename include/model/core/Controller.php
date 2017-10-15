<?php

/**
 * コントローラーで使えそうなメソッドをまとめておくクラス
 */
abstract class Controller{
    /* プロパティ定義エリア */
    protected $errorMsgs;           # エラーメッセージがあれば配列形式でここに入る
    protected $params;              # ビュー側に渡すパラメータをすべて格納しておく

    /**
     * コンストラクタ
     */
    public function __construct(){
        # エラーメッセージ用の変数を初期化
        $this->errorMsgs = array();

        # ビュー側に渡すパラメータをすべて格納しておく変数を初期化
        $params = array();
    }

    /**
     * HTMLのエスケープ用関数簡略化メソッド
     * @param  string $text HTMLエスケープを行いたい文字列を指定します
     * @return string       HTMLエスケープされた文字列が返ります
     */
    public function h($text){
        return htmlspecialchars($text, ENT_QUOTES, 'utf-8');
    }



    /**
     * POST通信で送られてきたデータを取得します
     * @param  string $name 取得したい配列名
     * @return mixed        POSTデータ通信で送られてきたデータが返ります
     */
    public function getPost($name){
        if ( isset($_POST[$name]) === true ){
            return $_POST[$name];
        }

        return '';
    }




    /**
     * POST通信で送られてきたデータを取得します
     * @param  string $name 取得したい配列名
     * @return string       GETデータ通信で送られてきたデータが返ります
     */
    public function getGet($name){
        if ( isset($_GET[$name]) === true ){
            return $_GET[$name];
        }

        return '';
    }



    /**
     * 接続がPOSTデータ通信かどうかを調べます
     * @return boolean POSTデータ通信あればtrue、そうでなければfalseが返ります
     */
    public function isPost(){
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
            return true;
        }

        return false;
    }



    /**
     * ログインをチェックするメソッドです
     * @return boolean ログイン状態であればtrue、そうでなければflaseが返ります
     */
    public function authCheck(){
        # ログインしている状態でこのページに来たらIndexに飛ばす
        if ( isset($_SESSION['USER_ID']) ){
            return true;
        }

        return false;
    }



    /**
     * 自分自身のファイルパスを返すメソッド
     *
     * @author Nな人<nnahito>
     * @return string サーバ上の自分自身のパスが返ります
     */
    public function getOwnPath() {
        return (string)$_SERVER['PHP_SELF'];
    }



    /**
     * リダイレクトを行うメソッドです
     * @param  string $url リダイレクトさせたいURLを指定します
     * @return void
     */
    public function redirect($url){
        header('Location: ' . $url);
        exit();
    }


    /**
     * Controllerを継承したクラスは必ずrunメソッドを持ち、
     * そこに処理を書かなければいけないという制約。
     */
    public abstract function run();


}
