<?php
# ブートストラップ！！！！
require_once './bootstrap.php';


# コントローラの呼び出し
$controller = new LoginController();
$controller->run();
