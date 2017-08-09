<?php
# クラスローダーを読み込む
require_once('../include/model/core/ClassLoader.php');

# クラスローダーをインスタンス化
$loader = new ClassLoader();

# 各ディレクトリをロードする
$loader->registerDir('../include/model/core');
$loader->registerDir('../include/model');
$loader->registerDir('../include/controller');

# ディレクトリを登録する
$loader->register();
