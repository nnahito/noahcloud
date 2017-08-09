<?php
abstract class Application{
    /* プロパティ定義エリア */
    protected $debug = false;
    protected $session;

    /**
     * コンストラクタ
     * @param boolean $debug デバッグの
     */
    protected function __construct( $debug = false ){
        # デバッグモード（デプロイするときはfalseにする）
        $this->setDebugMode($debug);

        # 初期設定
        $this->initialize();
    }



    /**
     * デバッグモードを有効にするかどうかを設定します
     * @param boolean $debug デバッグモードを有効にするならtrue、無効にするならfalseを指定
     */
    protected function setDebugMode($debug){
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
    protected function initialize(){
        # セッション管理モデルをインスタンス化
        $this->session = new Session();
    }



    /**
     * セッション情報を返します
     * @return Session セッションのインスタンスが返ります
     */
    public function getSession(){
        return $this->session;
    }

}
