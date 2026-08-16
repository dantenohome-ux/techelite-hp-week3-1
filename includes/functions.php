<?php
/* =============================================================
   サイト全体で使う小さな関数

   「毎回書くと長い・書き忘れると困る」処理を短くまとめただけの
   ラッパー関数を置く。ページ固有の処理はここには入れない
   （お問い合わせフォームの検証などは includes/form.php にある）。

   header.php / footer.php / form.php がそれぞれ読み込むので、
   どのページからでも使える。

   ※ 二重読み込みで関数が重複定義されないよう、
      読み込む側は require ではなく require_once を使うこと。
   ============================================================= */


/**
 * HTMLに値を出すときのエスケープ。
 *
 * htmlspecialchars($v, ENT_QUOTES, 'UTF-8') と同じだが、
 * 毎回3つの引数を書くのは長く、書き忘れがそのまま脆弱性になる。
 * 短い名前にして「出力は必ずこれを通す」という決まりを守りやすくしている。
 *
 *   ENT_QUOTES … シングルクォートも変換する（属性値の中に入れても壊れない）
 *   'UTF-8'    … 文字コードの指定。省略時の既定に頼らず明示する
 *
 * 例：h('<script>') → '&lt;script&gt;'
 */
function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}


/**
 * 別のページへ転送して、その場で処理を終える。
 *
 * header() は「送る予定のヘッダを積む」だけで処理を止めてくれない。
 * exit を書き忘れると、転送しつつ後続のHTMLまで出力してしまうため、
 * 2つをひとまとめにして書き忘れを防いでいる。
 *
 * 戻り値の never は「この関数は呼び出し元へ戻らない」という意味。
 */
function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}


/**
 * フォームから送信された（POSTされた）かどうか。
 *
 * $_SERVER['REQUEST_METHOD'] を直接比べてもよいが、
 * 綴りを間違えても気づきにくいので関数にしている。
 */
function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
}
