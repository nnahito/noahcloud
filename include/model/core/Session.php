<?php

/**
 * セッションを管理するためのクラス
 */
class ClassName{
    /*
     * プロパティ定義エリア
     */
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;

    /**
     * コンストラクタ
     * @param [type] argument [description]
     */
    public function __construct(){
        # セッションがスタートしていねければ
        if ( self::$sessionStarted === false ){
            # セッションをスタートする
            session_stat();

            # セッションフラグをたてる
            self::$sessionStarted = true;
        }
    }



    /**
     * セッションを登録するセッター
     * @param string $name  セッション名
     * @param string $value セッションの値
     */
    public function set($name, $value){
        # セッションを代入
        $_SESSION[$name] = $value;
    }



    /**
     * セッション名から、セッションを取得する
     * @param  string $name    セッション名
     * @param  string $default セッションの値のデフォルト値
     * @return string          セッションの値が返ります。セッションがなければデフォルト値が返ります。
     */
    public function get($name, $default = null){
        # セッションが存在すれば
        if ( isset($_SESSION[$name]) === true ){
            # その名前のセッションを返す
            return $_SESSION[$name];
        }

        # セッションがなければ、デフォルト値を返す
        return $default;

    }

}
