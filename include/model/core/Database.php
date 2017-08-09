<?php
/* PDOでのDB操作のクラス */
class Database{

    private static $instance;
    private $pdo;
    private $stmt;


    /**
     * コンストラクタ
     */
    private function __construct(){

        # データベースに接続
        try{
            $this->pdo = new PDO('sqlite3: noahcloud_db.sqlite;charset=utf8',
                                '',
                                '',
                                array(PDO::ATTR_EMULATE_PREPARES => false,
                                PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
                            );

            # 例外を投げる
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            # 常にFETCH_ASSOC
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


        }catch(PDOException $e) {
            die('データベース接続失敗。'.$e->getMessage());
        }

    }



    /**
     * シングルトンパターンで使う窓口
     * @return Database Databaseクラスのインスタンスが返ります
     */
    public function getInstance(){
        if ( isset(self::$instance) === false ){
            self::$instance = new Database();
        }

        return self::$instance;
    }


    /* executeするメソッド */
    public function execute($sql, $data=array()){
        $this->stmt = null;
        $this->stmt = $this->pdo->prepare($sql);

        $this->stmt->execute($data);
        return $this->stmt;
    }



    /**
     * SQLに対する結果をすべて配列で返します
     * @param  string $sql  SQL文を指定します
     * @param  array  $data SQL文のPlaceholderに当てはめるデータを連想配列で指定します
     * @return array        結果が連想配列で返ります
     */
    public function getFetchAll($sql, $data=array()){
        $this->execute($sql, $data);

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * SQL分に対する結果を一つ返します
     * @param  string $sql  SQL文を指定します
     * @param  array  $data SQL文のPlaceholderに当てはめるデータを連想配列で指定します
     * @return array        SQLに対する結果が1件のみ、連想配列で返ります
     */
    public function getFetch($sql, $data=array()){
        $this->execute($sql, $data);

        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * 最後に挿入されたA_Iの値を返す
     * @return int 最後に挿入されたAutoIncrementの値が返ります
     */
    public function getLastAI(){
        return $this->pdo->lastInsertId();
    }



    /**
     * トランザクションを開始します
     * @return boolean トランザクション処理を開始できたらtrue、そうでなければfalseが返ります
     */
    public function startTransaction(){
        try{
            # トランザクションの開始
            return $this->pdo->beginTransaction();

        }catch (Exception $e){
            # ロールバックをして終了
            $this->doRollBack();
            die('トランザクションの開始に失敗しました');
        }

    }


    /**
     * ロールバックを行います
     * @return boolean ロールバック成功時にtrue、失敗したらfalseが返ります
     */
    public function doRollBack(){
        try{
            return $this->pdo->rollBack();
        }catch (Exception $e){
            die('ロールバックに失敗しました');
        }

    }


    /**
     * コミット処理を行います
     * @return boolean コミット処理成功時にtrue、失敗時にfalseを返します
     */
    public function doCommit(){

        try{
            return $this->pdo->commit();
        }catch (Exception $e){
            $this->doRollBack();
            die('ロールバックに失敗しました');
        }

    }



    /**
     * final（オーバーライド）の禁止：cloneをできないようにする
     * @return void
     */
    public final function __clone(){
        throw new RuntimeException('Singletonパターンの為、cloneキーワードの使用は禁止されています。');
    }


}
