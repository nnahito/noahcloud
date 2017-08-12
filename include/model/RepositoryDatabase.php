<?php

/**
 * リポジトリDBを管理するModel
 */
class RepositoryDatabase{

    /* プロパティ定義エリア */
    private $db;


    /**
     * コンストラクタ
     */
    public function __construct(){
        # DBクラスから、DBインスタンスを受け取る
        $this->db = Database::getInstance();
    }


}
