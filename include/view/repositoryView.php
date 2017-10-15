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
                <li style="padding: 5px 0px;"><a href=#! class="z-depth-0 btn waves-effect waves-light center-align grey darken-3" style="width: 100%;">ファイル一覧</a></li>
                <li style="padding: 5px 0px;"><a href=#! class="z-depth-0 btn waves-effect waves-light center-align grey darken-3" style="width: 100%;">リポジトリ設定</a></li>
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
                            <th>No.</th>
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
                                <td><a href="#!" class="btn-flat waves-effect waves-light blue-text text-accent-2 blue lighten-5"><i class="material-icons center">cloud_download</i></a><?= $value['file_name'] ?></td>
                                <td><?= $value['upload_person_name'] ?></td>
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
