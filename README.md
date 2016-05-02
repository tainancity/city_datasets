縣市開放資料集索引
=========

為了加速縣市政府開放資料的推動，平行單位釋出資料的比對是常見工作，但現在除了 OKFN 評比( http://tw-city.census.okfn.org/ )之外並沒有其他相關索引； OKFN 評比是透過指定主題的方式，但實際執行時只希望找出一個簡單的答案，也就是 "xx縣市開放了這個資料集，oo縣市有沒有類似的？" ，因此希望開發一個程式去建立縣市資料集之間的連結（標籤）

安裝方式
=========

下載：

```
$ cd /var/www
$ git clone git@github.com:tainancity/city_datasets.git
$ cd city_datasets
```

環境設定：

```
$ cp -R tmp_default/ tmp
$ cp .htaccess.default .htaccess
$ cp webroot/.htaccess.default webroot/.htaccess
$ cp Config/core.php.default Config/core.php
$ cp Config/database.php.default Config/database.php
```

資料庫處理：

1. 在 MySQL 建立資料庫
2. 將資料庫的設定寫入 Config/database.php
3. 匯入 Config/sql/base_20160502.sql 資料，例如：
  1. `mysql -uroot -p your_db < Config/sql/base_20160502.sql`
4. 匯入的資料庫會需要重設管理者帳號，請先清空下面幾個資料表
  1. `TRUNCATE acos;`
  2. `TRUNCATE aros;`
  3. `TRUNCATE aros_acos;`
  4. `TRUNCATE groups;`
  5. `TRUNCATE group_permissions;`
  6. `TRUNCATE members;`
5. 如果只需要一個空的資料庫，可以匯入 Config/schema/schema.sql
6. 透過瀏覽器開啟網頁，進入登入畫面時會引導建立新的帳號、密碼
