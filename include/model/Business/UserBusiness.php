<?php

/**
* ユーザの状態を取り扱うビジネスロジック
*/
class UserBusiness
{

    /**
    * Applicationクラスのインスタンスを入れておくプロパティ
    * @var Application
    */
    private $_app;


    /**
    * コンストラクタ
    * @method __construct
    * @author Nな人<nnahito>
    */
    public function __construct() {

        # Applicationクラスのインスタンスをプロパティに入れる
        $this->_app = new Application();

    }


}
