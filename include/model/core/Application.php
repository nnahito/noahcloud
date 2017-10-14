<?php
class Application{
    /* プロパティ定義エリア */
    private $debug = false;
    private $session;
    private $database;

    /**
     * コンストラクタ
     * @param boolean $debug デバッグの
     */
    public function __construct( $debug = true ){
        # デバッグモード（デプロイするときはfalseにする）
        $this->setDebugMode($debug);

        # 初期設定
        $this->initialize();
    }



    /**
     * デバッグモードを有効にするかどうかを設定します
     * @param boolean $debug デバッグモードを有効にするならtrue、無効にするならfalseを指定
     */
    public function setDebugMode($debug){

        # デッバグモードを有効にするかどうかを判定
        if ( $debug === true ){

            # デバッグモードを有効にする
            $this->debug = true;
            ini_set('display_errors', 1);
            error_reporting(-1);

        }else{

            # デバッグモードを無効にする
            $this->debug = false;
            ini_set('display_errors', 0);

        }

    }



    /**
     * アプリケーションの初期設定を行います
     * @return void
     */
    public function initialize(){

        $this->session = new Session();                     # セッション管理モデルをインスタンス化
        $this->database = Database::getInstance();         # データベースを扱うモデルをインスタンス化

    }



    /**
     * セッション情報を返します
     * @return Session セッションのインスタンスが返ります
     */
    public function getSession(){

        return $this->session;

    }



    /**
     * データベースのインスタンスを返します
     * @return pdo データベースのインスタンスが返ります
     */
    public function getDatabase(){

        return $this->database;
        
    }

}
