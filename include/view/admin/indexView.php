<!DOCTYPE html>
<html lang="ja">
<head>
    <title>NOAH CLOUD Administrator</title>

    <meta charset="utf-8">

    <!-- CSSとJSを読み込む -->
    <?php include_once(INCLUDE_PATH . '/include/view/template/include.php'); ?>

</head>

<body>

    <!-- ヘッダー -->
    <?php include_once(INCLUDE_PATH . '/include/view/template/header.php'); ?>



    <div class="row">
        <!-- 設定一覧が表示される -->
        <div class="col s3" style="height: 100%">
            <ul>

                <li style="padding: 5px 0px;">
                    <a href='admin.php'>プロフィール設定</a>
                </li>

                <!-- 権限が管理者であれば、ここに設定ボタンを表示する -->
                <?php
                if ( $this->params['permission'] === 1 ) {
                ?>

                <li style="padding: 5px 0px;">
                    <a href='admin.php?mode=user'>ユーザ管理</a>
                </li>

                <li style="padding: 5px 0px;">
                    <a href='admin.php?mode=ripository'>リポジトリ管理</a>
                </li>

                <?php
                }
                ?>

            </ul>
        </div>


        <!-- メイン部分 -->
        <div class="col s9">

            <form action="admin.php" method="post">

                <table class='bordered striped'>

                    <tr>
                        <th width="30%">項目名</th>
                        <th>値</th>
                    </tr>

                    <tr>
                        <td>ユーザID</td>
                        <td><input type="text" name="user_id" value="<?= $this->params['user_info']['user_id']; ?>" readonly></td>
                    </tr>

                    <tr>
                        <td>ユーザ名</td>
                        <td><input type="text" name="user_name" value="<?= $this->params['user_info']['user_name']; ?>"></td>
                    </tr>

                    <tr>
                        <td>メールアドレス</td>
                        <td><input type="text" name="email" value="<?= $this->params['user_info']['email']; ?>"></td>
                    </tr>

                    <tr>
                        <td>パスワード（変更時のみ入力）</td>
                        <td><input type="password" name="password" value=""></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="center">
                            <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">edit</i>更新</button>
                        </td>
                    </tr>

                </table>

            </form>

        </div>

    </div>


</body>

</html>
