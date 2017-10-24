<!DOCTYPE html>
<html lang="ja">
<head>
    <title>NOAH CLOUD</title>

    <meta charset="utf-8">

    <!-- CSSとJSを読み込む -->
    <?php include_once(INCLUDE_PATH . '/include/view/template/include.php'); ?>

</head>

<body>

    <!-- ヘッダー -->
    <?php include_once(INCLUDE_PATH . '/include/view/template/header.php'); ?>



    <div class="row">
        <!-- ここにリポジトリの一覧が表示される -->
        <div class="col s3" style="height: 100%">
            <ul>
            <?php
                foreach ($this->params['repositories'] as $repository) {
            ?>
                    <li style="padding: 5px 0px;"><a href="repository.php?id=<?= $repository['repository_id'] ?>" class="z-depth-0 btn waves-effect waves-light center-align grey darken-3" style="width: 100%;"><?= $repository['repository_name'] ?></a></li>
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
