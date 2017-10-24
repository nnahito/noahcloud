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

        <!-- エラー -->
        <div class="col s8 offset-s2 red accent-1 red-text text-darken-4" style="border: 1px solid #b71c1c; border-radius: 3px; margin-top: 5px; padding: 5px;">

            <ul>

                <?php
                foreach ($this->errorMsgs as $key => $value) {
                ?>
                <li><?= $value ?></li>
                <?php
                }
                ?>

            </ul>

        </div>

    </div>

</body>

</html>
