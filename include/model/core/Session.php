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



    /**
     * セッションを削除します
     * @param  stinrg $name 削除したいセッション名を指定します
     * @return viod
     */
    public function remove($name){
        # 指定したセッションを削除
        unset($_SESSION[$name]);
    }



    /**
     * セッションを新しく置き換える
     * @param  boolean $destroy
     * @return void
     */
    public function regenerate($destroy = true){
        # セッションがまだ更新されていなければ
        if ( self::$sessionIdRegenerated === false ){
            # セッションを置き換える
            session_regenerate_id($destroy);

            # セッションを置き換えたことを覚えておく
            self::$sessionIdRegenerated = true;
        }
    }



    /**
     * セッションの保持値を空にする
     * @return viod
     */
    public function clear(){
        # セッションを空にする
        $_SESSION = array();
    }



    /**
     * セッションの更新を行います
     * @param void
     */
    public function setAuthenticated($bool){
        # セッションの更新を行ったことを記憶
        $this->set('_authenticated', (bool)$bool);

        # セッションの更新
        $this->regenerate();
    }



    /**
     * セッションの更新が可能かを確認します
     * @return boolean
     */
    public function isAuthenticated(){
        # セッションの更新を行ったことが有るかを返す
        return $this->get('_authenticated', false);
    }

}
