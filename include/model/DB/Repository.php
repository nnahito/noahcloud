<?php

/**
 * リポジトリ系の操作を行うDAO
 */
Class Repository
{

    /**
     * Applicationクラスのインスタンスを保存しておく変数
     * @var Application
     */
    private $_app = '';


    /**
     * コンストラクタ
     * @author Nな人<nnahito>
     */
    public function __construct() {

        # Applicationクラスをインスタンス化
        $this->_app = new Application();

    }



    /**
     * そのリポジトリの参加権限があるかどうかを取得します
     * 参加権限があればtrue、参加権限がなければfalseが返ります。
     *
     * @author Nな人<nnahito>
     * @param  int     $user_id       チェックするユーザID
     * @param  int     $repository_id チェックするリポジトリのID
     * @return boolean                参加権限があればtrue、参加権限がなければfalse
     */
    public function isAssigned(int $user_id, int $repository_id) {

        # ユーザがそのリポジトリの参加権限があるかどうかをチェックするSQL
        $sql = 'SELECT
            repository_group_id
        FROM
            repository_group
        WHERE
            user_id = :user_id AND repository_id = :repository_id
        ';

        # DBインスタンスの取得
        $database = $this->_app->getDatabase();

        # SQLの実行
        $result = $database->getFetch($sql, ['user_id' => $user_id, 'repository_id' => $repository_id]);

        # DBにレコードがあればOK
        if ( $result !== false ) {
            return (boolean) true;
        }

        return (boolean) false;

    }



    /**
     * 指定されたリポジトリIDのファイルリストを連想配列形式で返す
     *
     * @author Nな人<nnahito>
     * @param  int      $repository_id       ファイルリストを取得したいリポジトリIDを渡す
     * @return array                         指定されたリポジトリIDのファイルリストが連想配列形式で返ってきます
     */
    public function getFileList(int $repository_id) {

        # リポジトリのファイル一覧を取得するSQL
        $sql = '
        SELECT
            file_list.file_list_id
            , file_list.repository_id
            , file_list.file_name
            , file_list.upload_person AS `upload_person_id`
            , file_list.uploaded_at
            , user.user_name AS `upload_person_name`
        FROM
            file_list
        LEFT JOIN user
            ON file_list.upload_person = user.user_id
        WHERE
            file_list.repository_id = :repository_id
        ';

        # DBを扱うインスタンスを取得
        $database = $this->_app->getDatabase();

        # SQLの実行
        $result = $database->getFetchAll($sql, ['repository_id' => $repository_id]);

        # 返す
        return (array)$result;

    }

}
