<?php

return [
    'required'    => ':attributeを入力してください。',
    'max'         => ':attributeは:max文字まで入力できます。',
    'vpemail'     => ':attributeまたはパスワードが誤っています。。',
    'password'    => ':attributeまたはパスワードが誤っています。',
    'confirmed'   => 'メールアドレスと:attributeが異なっています。',
    'unique'      => ':attributeは既に使用されています。',
    'vp_date'      => ':attributeは' . VP_DATE_MIN . 'から' . MemberHelper::getMaxDate() . 'までの範囲で入力してください。',
    'vp_telephone' => ':attributeには有効な電話番号を入力してください。',
    'date'        => ':attributeはYYYY-mm-dd形式で入力してください。',
    'between'     => [
        'string' => 'メールアドレスまたは:attributeが誤っています。',
    ],
    'user_not_delete_boss' => '部下が残っているBOSSを削除しようとしています。',
    'user_not_me_own' => '次のデータには部下が残っています。削除するためには全ての部下を解除してください',
    'user_not_exists' => '存在しないID：%sに対するアクセスがありました。',
    'deleted_id' => '削除されたID：%sに対するアクセスがありました。',
    'not_direct_access' => '確認画面を経由せずに直接参照されました。',
    'exists_employ_child' => '参照データに部下が残っています。',
    'not_match_email' => 'これらの資格情報は、当社の記録と一致しません。',

    /**
     * Change attribute from name of input to placeholder
     */
    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'name' => '名前',
        'kana' => '名前（カナ）',
        'email_confirmation' => 'メールアドレス（確認）',
        'telephone_no' => '電話番号',
        'birthday' => '生年月日',
        'note' => 'ノート',
    ],
];
