=== Auto Delivery Interval Editor for Welcart ===
Contributors: kimikato
Tags: welcart, subscription, auto delivery
Version: 1.0.0
Requires at least: 6.6
Tested up to: 6.9
Requires PHP: 8.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WCEX Auto Delivery の定期購入データにおける購入間隔を、管理画面から変更できるようにする小さな補助プラグインです。

== Description ==

Auto Delivery Interval Editor for Welcart は、WCEX Auto Delivery の定期購入データにおける購入間隔を、管理画面から変更できるようにする拡張プラグインです。

通常、WCEX Auto Delivery の定期購入データでは、登録済みの購入間隔を変更することができません。
このプラグインを有効化すると、定期購入詳細画面の購入間隔表示をセレクトボックスに変更し、管理者が購入間隔を変更できるようにします。

このプラグインを利用するには、Welcart 及び WCEX Auto Delivery が必要です。

== Features ==

* 定期購入詳細画面で購入間隔を変更可能にします。
* 日単位の購入間隔を 1日毎～90日毎 から選択できます。
* 月単位の購入間隔を 1ヶ月毎～6ヶ月毎 から選択できます。
* 独自のデータベーステーブルや option は作成しません。

== Installation ==

1. プラグインファイルを `/wp-content/plugins/auto-delivery-interval-editor-for-welcart` ディレクトリにアップロードします。
2. WordPress 管理画面の「プラグイン」から有効化します。
3. Welcart および WCEX Auto Delivery が有効化されていることを確認してください。

== Frequently Asked Questions ==

= WCEX Auto Delivery が無効でも動作しますか？ =

いいえ。このプラグインは WCEX Auto Delivery が有効な場合のみ、必要なフックを登録します。
WCEX Auto Delivery が無効な場合、管理画面に警告を表示します。

= 独自のデータベーステーブルや option を作成しますか？ =

いいえ。このプラグインは独自のデータベーステーブルや option を作成しません。

= 購入間隔の選択範囲は変更できますか？ =

バージョン 1.0.0 時点では変更できません。
日単位は 1日毎～90日毎、月単位は 1ヶ月毎～6ヶ月毎 に対応しています。

== Changelog ==

= 1.0.0 =
* 初回公開版
* WCEX Auto Delivery の定期購入データにおける購入間隔変更に対応
* 日単位、月単位の購入間隔変更に対応
* PHP 8.2 に対応
* WordPress Coding Standards に準拠したクラス構成を採用
