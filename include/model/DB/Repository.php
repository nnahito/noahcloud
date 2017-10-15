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
     * 指定されたリポジトリIDに参加しているユーザの一覧を配列で返します
     *
     * @author Nな人<nnahito>
     * @param  int    $repository_id    アサインしているユーザ一覧を取得したいリポジトリID
     * @return array                    指定されたリポジトリIDに参加しているユーザの一覧が配列で返る
     */
    public function getAssignedUsers(int $repository_id) {

        # 指定されたIDのリポジトリにアサインしているユーザを探すSQL
        $sql = 'SELECT
                    user.user_id
                    , user.user_name
                FROM
                    repository_group
                LEFT JOIN user
                ON repository_group.user_id = user.user_id
                WHERE
                    repository_id = :repository_id
        ';

        # DBを扱うインスタンスを取得
        $database = $this->_app->getDatabase();

        # SQLの実行
        $result = $database->getFetchAll($sql, ['repository_id' => $repository_id]);

        # 返す
        return (array)$result;

    }



    /**
     * 指定されたリポジトリの、指定されたユーザの権限を削除する
     *
     * @author Nな人<nnahito>
     * @param  int    $user_id          削除するユーザID
     * @param  int    $repository_id    削除する対象のリポジトリID
     * @return boolean                  成功時にtrue、失敗時にfalseが返る
     */
    public function deleteUser(int $user_id, int $repository_id) {

        # 指定されたユーザIDをアサインしているリポジトリから削除するSQL
        $sql = 'DELETE FROM
                    repository_group
                WHERE
                    user_id = :user_id AND repository_id = :repository_id
        ';

        # DBを扱うインスタンスを取得
        $database = $this->_app->getDatabase();

        # SQL実行時につかう値をセット
        $data = [
              'user_id' => $user_id
            , 'repository_id' => $repository_id
        ];

        # SQLの実行
        $result = $database->execute($sql, $data);

        # 返す
        return (boolean)$result;

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
        $sql = 'SELECT
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



    /**
     * ファイルIDから、ファイル名を取得する（stringで返る）
     * ファイルIDがDB上に存在しなければfalseが返る
     *
     * @author Nな人<nnahito>
     * @param  int   $file_list_id  ファイルリストテーブルのID（ユニーク）
     * @return mixed                ファイル名（string）が返る。file_idがDB上になければfalseが返る
     */
    public function getFileNameById(int $file_list_id) {

        # ファイルIDからファイル名を取得するSQL
        $sql = 'SELECT
                    file_name
                FROM
                    file_list
                WHERE
                    file_list_id = :file_list_id
        ';

        # DBを扱うインスタンスを取得
        $database = $this->_app->getDatabase();

        # SQLの実行
        $result = $database->getFetch($sql, ['file_list_id' => $file_list_id]);

        # 結果がなければ
        if ( $result === false ) {
            return false;
        }

        # 結果を返す
        return (string)$result['file_name'];

    }

}
