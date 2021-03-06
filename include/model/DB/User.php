<?php

/**
 * ユーザの情報を扱うDAO
 */
Class User extends Database
{
    /**
     * データベースに接続するモデルを保存しておく変数
     * @var Database
     */
    private $_dao;


    /**
     * コンストラクタ
     */
    public function __construct() {
        # DAOをインスタンス化
        $this->_dao = Database::getInstance();
    }



    /**
     * 登録されているユーザ一覧を取得する
     *
     * @author Nな人<nnahito>
     * @return array    登録されているユーザが配列で返る
     */
    public function getUsersList() {

        # DBからユーザ情報を検索するSQL
        $sql = 'SELECT
                    user_id, user_name, email, password, permission
                FROM
                    user
        ';

        # SQLを実行
        $users = $this->_dao->getFetchAll($sql);

        # 返却
        return (array)$users;

    }



    /**
     * メールアドレスとパスワードからユーザ情報を取得する
     * （ログインのときとかに使う用）
     *
     * @param  string $email    メールアドレス
     * @param  string $password パスワード
     * @return mixed            ユーザ情報があればユーザの情報が配列で、なければfalseが返る
     */
    public function getLoginInfo(string $email, string $password) {

        # DBからユーザ情報を検索するSQL
        $sql = 'SELECT
                    user_id, user_name, email, password, permission
                FROM
                    user
                WHERE
                    email = :email
        ';

        # プレースホルダーに当てはめる情報軍
        $data = [
            'email' => $email
        ];

        # ユーザ情報をDBから取得
        $user_info = $this->_dao->getFetch($sql, $data);

        # データがなければ
        if ( count($user_info) === 1 ) {
            # falseを返す
            return (bool)false;
        }

        # パスワードをチェックする
        if ( password_verify($password, $user_info['password']) !== true ) {
            return (bool)false;
        }

        # 返却
        return (array)$user_info;

    }



    /**
     * ユーザの情報をユーザIDをキーに検索し、結果を連想配列で返します。
     * 結果がなければfalseが返ります。
     *
     * @method getUserInfoById
     * @author Nな人<nnahito>
     * @param  int             $user_id     ユーザIDを指定。ここのユーザIDはDBのユニークな値（user_id）のことを指す。
     * @return array|bool                   結果があればDBの検索結果が連想配列で、結果がなければfalseが返る。
     */
    public function getUserInfoById(int $user_id) {

        # DBからユーザ情報を取得するSQL
        $sql = 'SELECT
                    user_id
                    , user_name
                    , email
                    , password
                    , permission
                FROM
                    user
                WHERE
                    user_id = :user_id
        ';

        # プレースホルダーに入れる値
        $data = ['user_id' => $user_id];

        # ユーザ情報を取得
        $user_info = $this->_dao->getFetch($sql, $data);

        # データがなければ
        if ( count($user_info) === 1 ) {
            # falseを返す
            return (bool)false;
        }

        # 結果を配列で返す
        return (array)$user_info;

    }



    /**
     * ユーザの権限をDBから取得して返す
     *
     * @param  int    $user_id  ユーザIDを指定
     * @return int    値が取得できれば権限をintで、取得に失敗した場合は0が返る
     */
    public function getUserPermission(int $user_id) {

        # DBからユーザ情報を検索するSQL
        $sql = 'SELECT
                    permission
                FROM
                    user
                WHERE
                    user_id = :user_id
        ';

        # プレースホルダーに当てはめる用
        $data = [
            'user_id' => $user_id
        ];

        # DBからユーザ情報を取得
        $permission = $this->_dao->getFetch($sql, $data);

        # ユーザIDが存在していなかったらNULLが返ってきているので、NULLの場合は
        if ( $permission === false ) {
            # 0を返却
            return 0;
        }

        # データが存在していれば、int型でパーミッションを返す
        return (int)$permission['permission'];
    }



    /**
     * ユーザの情報を更新します
     *
     * @method updateUserData
     * @author Nな人<nnahito>
     * @param  int            $user_id      ユーザIDを指定
     * @param  array          $data         更新するユーザ
     * @return pdo                          PDOのステートメントを返す
     */
    public function updateUserData(int $user_id, array $data) {

        # ユーザIDを元に、データを更新するSQL
        $sql = 'UPDATE user
                SET
                    user_name = :user_name
                    , email = :email
                    , password = :password
                WHERE
                    user_id = :user_id
        ';

        # SQLを実行
        $statement = $this->_dao->execute($sql, $data);

        # ステートメントを返す
        return $statement;

    }

}
