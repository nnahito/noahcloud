<?php
# インクルードフォルダのパスの設定
const INCLUDE_PATH = '../';

# クラスローダーを読み込む
require_once(INCLUDE_PATH . '/include/model/core/ClassLoader.php');

# クラスローダーをインスタンス化
$loader = new ClassLoader();

# 各ディレクトリをロードする
$loader->registerDir(INCLUDE_PATH . '/include/model/core');
$loader->registerDir(INCLUDE_PATH . '/include/model/DB');
$loader->registerDir(INCLUDE_PATH . '/include/model/Business');
$loader->registerDir(INCLUDE_PATH . '/include/model');
$loader->registerDir(INCLUDE_PATH . '/include/controller');

# ディレクトリを登録する
$loader->register();
