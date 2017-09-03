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
        <!-- ここにリポジトリの設定一覧が表示される -->
        <div class="col s3" style="height: 100%">
            <ul>
                <li><a href=#! class="waves-effect waves-teal btn-flat">ファイル一覧</a></li>
                <li><a href=#! class="waves-effect waves-teal btn-flat">リポジトリ設定</a></li>
            </ul>
        </div>

        <!-- ファイル -->
        <div class="col s9">
            <!-- ファイルをアップロードするフォーム -->
            <div class="input-field">
                <form action="upload.cgi" enctype="multipart/form-data" method="post">
                    <input type="file" name="upfile">
                    <input type="submit" name="submit" value="アップロード" class="waves-effect waves-light btn">
                    <input type="hidden" name="repository_id" value="<?= $this->params['repository_id'] ?>">
                    <input type="hidden" name="upload_person" value="1">
                </form>
            </div>

            <!-- ファイル一覧 -->
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ファイル名</th>
                            <th>アップロード者</th>
                            <th>アップロード日</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        # ファイルのリストを吐き出していく
                        foreach ($this->params['file_list'] as $key => $value) {
                            ?>
                            <tr>
                                <td><?= $value['file_list_id'] ?></td>
                                <td><?= $value['file_name'] ?></td>
                                <td><?= $value['upload_person'] ?></td>
                                <td><?= $value['uploaded_at'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</body>

</html>
