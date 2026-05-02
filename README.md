# Auto Delivery Interval Editor for Welcart

WCEX Auto Delivery の定期購入データにおける購入間隔を、管理画面から変更できるようにする WordPress プラグインです。

## 概要

Auto Delivery Interval Editor for Welcart は、Welcart 拡張プラグインである WCEX Auto Delivery 向けの小さな補助プラグインです。

定期購入詳細画面の購入間隔表示をセレクトボックスに変更し、管理者が登録済みの定期購入データの購入間隔を変更できるようにします。

## 主な機能

- 定期購入詳細画面で購入間隔を変更可能にします
- 日単位の購入間隔を 1日毎〜90日毎 から選択できます
- 月単位の購入間隔を 1ヶ月毎〜6ヶ月毎 から選択できます
- 独自のデータベーステーブルや option は作成しません

## 必要環境

- WordPress 6.6 以上
- PHP 8.2 以上
- Welcart 2.11.4 以上
- WCEX Auto Delivery 1.7.5 以上

## インストール

1. GitHub Releases の Assets から `auto-delivery-interval-editor-for-welcart-x.x.x.zip` をダウンロードします
2. WordPress 管理画面の「プラグイン > 新規追加 > プラグインのアップロード」から zip ファイルをアップロードします
3. プラグインを有効化します
4. Welcart および WCEX Auto Delivery が有効化されていることを確認します

`Source code (zip)` ではなく、配布用 zip の利用を推奨します。

## 注意事項

このプラグインは WCEX Auto Delivery の内部フックを利用しています。

WCEX Auto Delivery 側の仕様変更により、将来のバージョンで動作しなくなる可能性があります。

## ライセンス

GPL-2.0-or-later
