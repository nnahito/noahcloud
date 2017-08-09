<?php
# ブートストラップ！！！！
require_once './bootstrap.php';


# Indexの呼び出し
$index = new IndexController();
$index->run();
