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
        <!-- サイドメニュー -->
        <div class="col s3" style="height: 100%">
            <ul>

                <li style="padding: 5px 0px;">
                    <a href="./repository.php?id=<?= $this->params['repository_id'] ?>" class="z-depth-0 btn waves-effect waves-light center-align grey darken-3 modal-trigger" style="width: 100%;">ファイル一覧</a>
                </li>

            </ul>
        </div>


        <!-- 設定 -->
        <div class="col s9">

            <!-- ユーザ追加フォーム -->
            <form action="<?= $this->getOwnPath() ?>" method="post">

                <div class="input-field">
                    <select>
                        <option value="" disabled selected>追加したいユーザを選択してください</option>
                        <?php
                        foreach ($this->params['all_users'] as $key => $value) {
                        ?>
                        <option value="<?= $value['user_id'] ?>"><?= $value['user_name'] ?>《<?= $value['email'] ?>》</option>
                        <?php
                        }
                        ?>
                    </select>
                    <label>Materialize Select</label>

                    <div class="right-align">
                        <button type="submit" class="btn waves-effect waves-light">ユーザの追加</button>
                    </div>
                </div>

            </form>

            <!-- アサインユーザ一覧 -->
            <table class="bordered">

                <tr>
                    <th>No.</th>
                    <th>名前</th>
                    <th>削除</th>
                </tr>

                <?php
                foreach ($this->params['assigned_users'] as $key => $value) {
                ?>
                <tr>
                    <td><?= ($key+1) ?></td>
                    <td><?= $value['user_name'] ?></td>
                    <td><a href="./repository.php?id=<?= $this->params['repository_id'] ?>&page=delete&delete_user_id=<?= $value['user_id'] ?>" class="btn waves-effect waves-light red darken-2">削除</a></td>
                </tr>
                <?php
                }
                ?>
            </table>

        </div>

    </div>


    <script>

    $(function(){
        $('select').material_select();
    })

    </script>



</body>

</html>
