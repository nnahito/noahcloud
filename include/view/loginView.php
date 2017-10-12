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
        <!-- ここにログインフォームが表示される -->
        <div class="col s8 offset-s2">

            <!-- エラーを表示する場所 -->
            <?php
            if ( count($this->errorMsgs) > 0 ) {
            ?>
                <div class="red accent-1 red-text text-darken-4" style="border: 1px solid #b71c1c; border-radius: 3px; margin: 5px; padding: 5px;">
                    <?php
                    foreach ($this->errorMsgs as $key => $value) {
                        echo $value.'<br>';
                    }
                    ?>
                </div>
            <?php
            }
            ?>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">

                <!-- メールアドレス -->
                <div class="input-field col s12">
                    <input id="email" name="email" type="text" class="validate" value="<?= $this->getPost('email'); ?>">
                    <label for="email">メールアドレス</label>
                </div>

                <!-- メールアドレス -->
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate" value="<?= $this->getPost('password'); ?>">
                    <label for="password">パスワード</label>
                </div>

                <!-- ログインボタン -->
                <div class="col s12 center-align">
                    <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">directions_run</i>ログイン</button>
                </div>

            </form>

        </div>

    </div>

</body>

</html>
