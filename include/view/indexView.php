<!DOCTYPE html>
<html lang="ja">
<head>
    <title>NOAH CLOUD</title>

    <meta charset="utf-8">

    <!-- CSSとJSを読み込む -->
    <?php include_once('../include/view/template/include.php'); ?>

</head>

<body>

    <!-- ヘッダー -->
    <?php include_once('../include/view/template/header.php'); ?>



    <div class="row">
        <!-- ここにリポジトリの一覧が表示される -->
        <div class="col s3" style="height: 100%">
            <ul>
            <?php
                foreach ($this->params['repositories'] as $repository) {
            ?>
                    <li><a href="repository.php?id=<?= $repository['repository_id'] ?>" class="btn-flat waves-effect waves-light"><?= $repository['repository_name'] ?></a></li>
            <?php
                }
            ?>
            </ul>
        </div>

        <!-- 通知一覧 -->
        <div class="col s9">
            本文
        </div>

    </div>

</body>

</html>
