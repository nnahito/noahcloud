
# -*- coding: utf-8 -*-

# 必要モジュールの読み込み
import os
import cgi
import cgitb
import sqlite3
import datetime

cgitb.enable()


# ファイルの情報をDBに書き込む準備
conn = sqlite3.connect('../database/noahcloud_db.sqlite')
c = conn.cursor()


# ファイルの最大サイズ上限を決める（単位は「Byte」）
cgi.maxlen = 1024 * 1000 * 500              # 1024 * 1000 * 500 = 500MB

# フォームからの値を受け取る
form = cgi.FieldStorage()

# ファイルの取得
fileitem = form['upfile']

# リポジトリIDを取得
repositoryID = form['repository_id'].value

# アップロード者のIDを取得
uploadPersonID = form['upload_person'].value

# ファイルが正常にアップロードされていたら
if fileitem.filename:
    # ファイルネームだけの抜き出し（ディレクトリトラバーサルアタック回避の意味も込めて）
    fn = os.path.basename(fileitem.filename)

    # ファイルの書き出し
    open('./' + fn, 'wb').write(fileitem.file.read())

    # 今日の日付けを取得
    todaydetail = datetime.datetime.today()
    date = todaydetail.strftime("%Y/%m/%d %H:%M:%S")

    # DBにファイルの情報を書き込み
    insert_sql = 'insert into file_list (repository_id, file_name, upload_person, uploaded_at) values (?, ?, ?, ?);'
    filedata = (repositoryID, fn, uploadPersonID, date)
    c.execute(insert_sql, filedata)
    conn.commit()

    message = 'The file "' + fn + '" was uploaded successfully'

else:
    message = 'No file was uploaded'


print ("""\
Content-Type: text/html\n
<html>
<body>
    <p>%s</p>
</body>
</html>
""" % (filedata,))
