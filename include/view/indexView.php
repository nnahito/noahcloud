<!DOCTYPE html>
<html lang="ja">
<head>
    <title>NOAH CLOUD</title>

    <meta charset="utf-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>

</head>

<body>

    <nav class="grey darken-4 white-text">
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo">NOAH CLOUD</a>
            <a href="#!" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="sass.html">設定</a></li>
            </ul>
            <ul class="side-nav" id="mobile-demo">
                <li><a href="sass.html">設定</a></li>
            </ul>
        </div>
    </nav>



    <div class="row">
        <!-- ここにリポジトリの一覧が表示される -->
        <div class="col s3" style="height: 100%">
            <ul>
            <?php
                foreach ($this->params['repositories'] as $repository) {
            ?>
                    <li>○<a href="repository.php?id=<?= $repository['repository_id'] ?>"><?= $repository['repository_name'] ?></a></li>
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
