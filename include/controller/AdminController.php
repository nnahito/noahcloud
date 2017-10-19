<?php

/**
 * 管理者ページを制御するコントローラー
 */
class AdminController extends Controller
{

  /**
   * Applicationクラスを保存しておく変数
   * @var Application
   */
  private $_app;



  /**
   * コンストラクタ
   * いつもここからはじまるのさ
   *
   * @method __construct
   * @author Nな人<nnahito>
   */
  public function __construct() {

    # Applicationクラスをインスタンス化
    $this->_app = new Application();

    # Userのデータを扱うDAOをインスタンス化
    $userDao = new User();

    # セッションインスタンスを取得
    $session = $_app->getSession();

    # USERIDをセッションから取得
    $user_id = $session->get('USER_ID');

    # 通常ユーザとしてログインしているかを確認
    if ( $this->authCheck() !== true ) {
      # ログインしていなければさようなら
      header('Location: ./login.php');
      exit;
    }

    # 権限を確認（permission = 1 以外は受け付けない）
    if ( (int)$user->getUserPermission($user_id) !== 1 ) {
        # 権限がなければさようなら
        header('Location: ./login.php');
        exit;
    }

    # 管理者モードにログインしているかをチェックする

  }





}
