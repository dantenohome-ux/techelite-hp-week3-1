<?php
/* =============================================================
   お問い合わせフォームの共通処理

   contact.php / confirm.php / thanks.php の3ファイルが読み込む。
   画面には何も出力しない（HTMLより先に読み込むことで、
   session_start() とリダイレクトを確実に行えるようにしている）。

   ※ 二重読み込みで関数が重複定義されないよう、
      呼び出し側は require ではなく require_once を使うこと。
   ============================================================= */

// h() や redirect() などの共通関数を使うため読み込む
require_once __DIR__ . '/functions.php';

// セッション開始。すでに開始済みなら何もしない
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


/* -------------------------------------------------------------
   1. フォームの項目定義
   ------------------------------------------------------------- */

// お問い合わせ内容の上限文字数（js/main.js の MAX_MESSAGE_LENGTH と同じ値）
const MAX_MESSAGE_LENGTH = 1000;

/**
 * 項目名 => 表示ラベル・必須かどうか。
 * 入力欄・確認画面・エラー文の並び順はすべてこの定義に従う。
 * 項目を増やすときはここに1行足し、必要なら contact_validate() にルールを書く。
 */
const CONTACT_FIELDS = [
    'name'    => ['label' => 'お名前',           'required' => true],
    'email'   => ['label' => 'メールアドレス',   'required' => true],
    'tel'     => ['label' => '電話番号',         'required' => false],
    'message' => ['label' => 'お問い合わせ内容', 'required' => true],
];


/* -------------------------------------------------------------
   2. 入力値の取り出し
   ------------------------------------------------------------- */

/**
 * 配列（$_POST やセッションの保存値）から、定義した4項目だけを取り出して trim する。
 *
 * 定義にないキーは捨てるので、フォームに無い値を混ぜて送られても取り込まない。
 * 空配列を渡せば「全項目が空文字」の状態が返るため、
 * 初回表示時の初期値づくりにもそのまま使える。
 */
function contact_input(array $source): array
{
    $input = [];

    foreach (array_keys(CONTACT_FIELDS) as $name) {
        // 配列などが送られてきた場合に備え、文字列以外は空として扱う
        $value = $source[$name] ?? '';
        $input[$name] = is_string($value) ? trim($value) : '';
    }

    return $input;
}


/* -------------------------------------------------------------
   3. 入力値の検証
   ------------------------------------------------------------- */

/**
 * 検証してエラーを返す。
 * 戻り値は「項目名 => 日本語のエラー文」の配列で、問題なければ空配列。
 * 空配列かどうか（empty()）で成否を判定する。
 *
 * ルールは js/main.js の rules と揃えてある。
 * JavaScript は「入力中に気づかせる」ためのもので、切ることもできるため、
 * 最終的な可否はこのサーバー側の判定で決める。
 */
function contact_validate(array $input): array
{
    $errors = [];

    // ---- 必須チェック（定義の required を見る） ----
    foreach (CONTACT_FIELDS as $name => $field) {
        if ($field['required'] && $input[$name] === '') {
            $errors[$name] = $field['label'] . 'を入力してください';
        }
    }

    // ---- メールアドレスの形式 ----
    // 構造の判定は PHP 標準の filter_var に任せる。
    // 「@が1つだけか」「ドットが連続していないか」「先頭や末尾がドットでないか」
    // といった細かい決まりを、自前の正規表現より正確に見てくれる。
    //
    // ただし filter_var は a@a.a のようにトップレベルドメインが1文字でも通してしまう。
    // 実在するTLDは2文字以上（.jp / .com など）なので、そこだけ追加で確かめる。
    if (!isset($errors['email']) && $input['email'] !== ''
        && (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)
            || !preg_match('/\.[A-Za-z]{2,}\z/', $input['email']))) {
        $errors['email'] = 'メールアドレスの形式が正しくありません';
    }

    // ---- 電話番号の形式（任意項目なので、入力があるときだけ見る） ----
    // 数字とハイフンが並んでいるだけでは 0-0-0000000000 のような形も通ってしまうので、
    // 日本の電話番号の組み立てに沿って2段階で確かめる。
    //
    //   1. 形：「0で始まる3つの数字の組をハイフンで区切る」（03-1234-5678／090-1234-5678）
    //          または「ハイフン無しで続ける」（0312345678）のどちらか
    //   2. 桁数：ハイフンを除いて10桁（固定電話）か11桁（携帯・IP電話）
    //
    // 形だけだと 0123-1234-5678 のような桁数過多を、
    // 桁数だけだと 0-0-0000000000 のような区切り方を、それぞれ見逃してしまう。
    if ($input['tel'] !== '') {
        $shape_ok = preg_match('/\A0\d{1,3}-\d{1,4}-\d{4}\z/', $input['tel'])
                 || preg_match('/\A0\d{9,10}\z/', $input['tel']);

        $digit_count = strlen(preg_replace('/\D/', '', $input['tel']));

        if (!$shape_ok || $digit_count < 10 || $digit_count > 11) {
            $errors['tel'] = '電話番号は市外局番から半角数字で入力してください（例：03-1234-5678）';
        }
    }

    // ---- お問い合わせ内容の文字数 ----
    // strlen はバイト数を数えるため、日本語では mb_strlen（文字数）を使う
    if (!isset($errors['message']) && mb_strlen($input['message']) > MAX_MESSAGE_LENGTH) {
        $errors['message'] = 'お問い合わせ内容は' . MAX_MESSAGE_LENGTH . '文字以内でご入力ください';
    }

    return $errors;
}
