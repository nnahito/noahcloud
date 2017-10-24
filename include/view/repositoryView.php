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
        <!-- ここにリポジトリの設定一覧が表示される -->
        <div class="col s3" style="height: 100%">
            <ul>

                <li style="padding: 5px 0px;">
                    <a href="./repository.php?id=<?= $this->params['repository_id'] ?>&page=setting" class="z-depth-0 btn waves-effect waves-light center-align grey darken-3 modal-trigger" style="width: 100%;">リポジトリ設定</a>
                </li>

            </ul>
        </div>

        <!-- ファイル -->
        <div class="col s9">
            <!-- ファイルをアップロードするフォーム -->
            <div class="input-field">
                <form id="upload_form" action="upload.cgi" enctype="multipart/form-data" method="post">
                    <input type="file" name="upfile">
                    <button id="upbutton" type="submit" name="submit" class="waves-effect waves-light btn">アップロード</button>
                    <input type="hidden" name="repository_id" value="<?= $this->params['repository_id'] ?>">
                    <input type="hidden" name="upload_person" value="<?= $this->params['user_id'] ?>">
                </form>
            </div>

            <!-- アップロード中のプログレスバー -->
            <div class="progress" style="display: none;">
                <div class="determinate" style="width: 0%"></div>
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
                                <td>
                                    <a href="./download.php?repository_id=<?= $this->params['repository_id'] ?>&file_id=<?= $value['file_list_id'] ?>" class="btn-flat waves-effect waves-light blue-text text-accent-2 blue lighten-5">
                                        <i class="material-icons center">cloud_download</i>
                                    </a>
                                    <?= $value['file_name'] ?>
                                </td>
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



    <script>

    $(document).submit(function(){
        // フォームデータの取得
        let form_data = new FormData( document.getElementById('upload_form') );

        // XMLHttpRequestによるアップロード処理
        var xhttpreq = new XMLHttpRequest();

        // アップロードスタートイベント
        xhttpreq.upload.onloadstart = function(e){
            // プログレスバーを表示
            $('.progress').fadeIn(100);

            // アップロードボタンを非表示
            $('#upbutton').fadeOut(100);
        }

        // アップロード更新イベント
        xhttpreq.upload.onprogress = function(e){
            // プログレスバーを動かす
            var progress = (e.loaded / e.total * 100).toFixed(3);
            $('.determinate').css('width', (progress)+'%');
        }

        // アップロード完了イベント
        xhttpreq.upload.onloadend = function(e){
            // プログレスバーを0％に戻す
            for (var i = 100; i > 0; i--) {
                $('.determinate').css('width', (i)+'%');
            }

            // プログレスバーを非表示
            $('.progress').fadeOut(800);

            // アップロードボタンを表示
            $('#upbutton').fadeIn(100);

            // リロード（またやり方を変更する）
            location.reload();
        }

        // 接続先/接続方法指定
        xhttpreq.open("POST", "./upload.cgi", true);

        // データの送信
        xhttpreq.send(form_data);

        return false;
    });

    </script>

</body>

</html>
