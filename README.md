# Sample Usage of Kagome API on Docker from PHP7 Container

このリポジトリは以下の記事のためのサンプルのリポジトリです。

- [Kagome on Docker で日本語形態素解析 API を手軽に利用する（わかち書き解析）](https://qiita.com/KEINOS/items/8b5e3a251430db89de3f)

形態素解析 `kagome` の WebAPI 用 Docker コンテナを、他のコンテナからリクエストするサンプルが公開されています。

具体的には、`kagome` のコンテナの WebAPI に PHP7 のコンテナから HTTP リクエストして、その解析結果を PHP のビルトインサーバーで表示します。

## ディレクトリ構成

```text
.
├── docker-compose.yml
├── Containers
│   └── cont1-php // PHP コンテナ用ディレクトリ
│       ├── Dockerfile
│       └── src
│           └── index.php
├── LICENSE
└── README.md
```

## Usage

1. リポジトリをローカルに `clone` もしくはコピーして以下を実行。`kagome` と `php` のコンテナがバックグランドで起動します。

    ```shellsession
    $ docker-compose up -d
    Creating network "kagome-on-docker-sample_default" with the default driver
    Creating kagome ... done
    Creating php    ... done
    ```

2. ブラウザから `http://localhost:8888/` にアクセスして、形態素解析の結果が以下のように表示されれば成功。

<details><summary>ブラウザの出力結果</summary><div><br>

```json
{
    "status": true,
    "tokens": [
        {
            "id": 10618,
            "start": 0,
            "end": 1,
            "surface": "お",
            "class": "KNOWN",
            "features": [
                "接頭詞",
                "名詞接続",
                "*",
                "*",
                "*",
                "*",
                "お",
                "オ",
                "オ"
            ]
        },
        {
            "id": 190872,
            "start": 1,
            "end": 3,
            "surface": "寿司",
            "class": "KNOWN",
            "features": [
                "名詞",
                "一般",
                "*",
                "*",
                "*",
                "*",
                "寿司",
                "スシ",
                "スシ"
            ]
        },
        {
            "id": 381475,
            "start": 3,
            "end": 5,
            "surface": "食べ",
            "class": "KNOWN",
            "features": [
                "動詞",
                "自立",
                "*",
                "*",
                "一段",
                "連用形",
                "食べる",
                "タベ",
                "タベ"
            ]
        },
        {
            "id": 39236,
            "start": 5,
            "end": 7,
            "surface": "たい",
            "class": "KNOWN",
            "features": [
                "助動詞",
                "*",
                "*",
                "*",
                "特殊・タイ",
                "基本形",
                "たい",
                "タイ",
                "タイ"
            ]
        }
    ]
}
```

</div></details>

## 具体的な動作

1. `kagome` と `php` のコンテナが起動すると、各々 Web サーバーとして 80 番ポートで待機します。
2. `php` のコンテナのみ 8888 ポートで外部（ホスト側）からアクセスできるようになっているので、ブラウザなどから `http://localhost:8888/` とアクセスすると `index.php` が実行されます。
3. `index.php` は、同じ Docker ネットワーク内にある `kagome` のサーバー（`http://kagome/a`）に解析したいデータを `PUT` でリクエストします。
4. `index.php` が `kagome` の形態素解析結果を受け取ると、JSON 形式で結果を表示します。

詳しくは以下のファイルの中身をご覧ください。

- ./docker-compose.yml
- ./Containers/cont1-php/Dockerfile
- ./Containers/cont1-php/src/index.php
