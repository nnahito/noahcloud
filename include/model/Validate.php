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


}
