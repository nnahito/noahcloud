<?php

/**
 * クラスをオートロードするクラス
 */
class ClassLoader{
    /* プロパティ定義エリア */
    protected $dirs;                # オートロードするPHPが入っているディレクトリ


    /**
     * コンストラクタ
     */
    public function __construct(){
        # プロパティの初期化
        $dirs = array();
    }



    /**
     * 必要なクラスを自動で読み込んで登録します
     * @return void
     */
    public function register(){
        spl_autoload_register( array($this, 'loadClass') );
    }



    /**
     * 読み込みたいPHPが保存してあるディレクトリをプロパティに読み込むメソッド
     * @param  string $dir ディレクトリ名を入力
     * @return void
     */
    public function registerDir($dir){
        # 渡されたディレクトリパスをプロパティに追加
        $this->dirs[] = $dir;
    }



    /**
     * 指定されたディレクトリの中のPHPをすべてrequireする
     * @param  string $class requireしたいPHPが入っているディレクトリ名を指定
     * @return void
     */
    public function loadClass($class){
        # 入力されたディレクトリの中身をすべて取り出す
        foreach( $this->dirs as $dir ){
            # ファイル名のパスを作成
            $file = $dir . '/' . $class . '.php';

            # もし、ファイルが読み取り可能であれば
            if ( is_readable($file) === true ){
                # ファイルをrequireする
                require_once($file);

                # なんでrequireしてるのにreturnするの？
                return;
            }

        }

    }

}
