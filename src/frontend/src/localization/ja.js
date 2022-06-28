const ja = {
  translation: {
    // define translations below
    form: {
      required: 'この項目は必須です。',
      email: 'メール形式が無効です。',
      password: {
        minLength: 'パスワードは8文字以上である必要があります。',
        confirm: 'パスワードの確認が一致しません。',
        strong:
          'パスワードには、大文字1文字、特殊文字1文字、および少なくとも8文字が含まれている必要があります。',
      },
    },
    labels: {
      first_name: 'ファーストネーム',
      last_name: '苗字',
      login: 'ログイン',
      signup: 'サインアップ',
      remember_me: '私を覚えてますか',
      forgot_password: 'パスワードをお忘れですか？',
      email_address: '電子メールアドレス',
      password: 'パスワード',
      confirm_password: 'パスワードを認証する',
      submit: '送信',
      update: 'アップデート',
      save: '保存する',
      add_new: '新しく追加する',
      reset_password: 'パスワードを再設定する',
      new_password: '新しいパスワード',
      confirm_new_password: '新しいパスワードを確認',
      enter_keyword: 'キーワードを入力してください',
      get_started: 'はじめましょう',
      integrations: '統合',
      settings: '設定',
      documentation: 'ドキュメンテーション',
      fullname: 'フルネーム',
      inquiry_content: 'お問合わせ内容',
      navigation: 'ナビゲーション',
      resources: 'リソース',
    },
    pages: {
      signup: {
        agree_to_terms: '[サインアップ]をクリックすると、読んだことに同意したことになります',
        terms_conditions: '規約と条件',
        create_free_account: '無料アカウントを作成する',
      },
      forgot_password: {
        sub_heading: 'アカウントを復旧するには、以下にメールアドレスを入力してください。',
        success: 'パスワードをリセットする方法については、受信トレイを確認してください。',
      },
      reset_password: {
        sub_heading: '新しいパスワードを入力してください。',
        success: 'パスワードは正常に更新されました。',
      },
      users: {
        user_created: 'ユーザーが作成されました。',
        user_updated: 'ユーザーの詳細が更新されました。',
        user_deleted: 'ユーザーが削除されました',
        add_user: 'ユーザーを追加する',
        edit_user: 'ユーザー編集',
        delete_user: 'ユーザーを削除',
        first_name: 'ファーストネーム',
        last_name: '苗字',
        email_address: '電子メールアドレス',
        status: '状態',
        delete_confirmation: '選択したユーザーを削除してもよろしいですか？',
      },
      activate: {
        heading: 'アカウントをアクティブ化',
        subtitle: 'アカウントをアクティブ化するためのパスワードを設定します。',
        activated: 'アカウントが有効になりました。 これで、アカウントにログインできます。',
      },
      dashboard: {
        main_heading: 'React Base Templateへようこそ！',
        sub_heading: 'Reactプロジェクトの開発に関する軽量の定型文。',
        new_users: '新しいユーザー',
        total_sales: '総売上高',
        total_orders: '総注文数',
      },
      not_found: {
        sub_heading: 'お探しのページは削除されたか、別の場所へ移動した可能性があります。',
        back_to_top: 'トップページへ戻る',
      },
      faq: {
        heading: 'よくあるご質問',
        sub_heading: 'お客様からお問い合わせいただく質問をQ&A形式でまとめました。',
      },
      inquiry: {
        heading: 'お問い合わせ',
        sub_heading: 'このままお問い合わせされる方は下記のフォームにご入力ください。',
        success_message: 'お問い合わせを送信しました。',
        failed_message: '送信中にエラーが発生しました。',
      },
      profile: {
        heading: 'お問い合わせをお送りしました。',
        sub_heading: '送信中にエラーが発生しました。',
        success_message: '詳細が正常に更新されました。',
        failed_message: '更新に失敗しました。',
      },
      landing: {
        main_heading: 'React Base Templateへようこそ！',
        sub_heading: 'Reactプロジェクトの開発に関する軽量の定型文。',
        why_heading: 'なぜベーステンプレートを使用するのですか？',
        docker: {
          heading: '柔軟な環境',
          description:
            '「自分のマシンで動作する」という問題を完全に解消します。 環境のセットアップ、環境固有の問題のデバッグ、およびより移植性が高くセットアップが簡単なコードベースに費やす時間を短縮します。',
        },
        react: {
          heading: '高速で直感的なUI',
          description:
            'ReactJSは非常に直感的に操作でき、UIのレイアウトに双方向性を提供します。 これらのコンポーネントを利用して1つの場所に統合できるように、構成可能です。 したがって、コードははるかに保守可能で柔軟になります。',
        },
        laravel: {
          heading: '強力なAPI',
          description:
            'LaravelのAPI機能を利用してバックエンドAPIを簡単に開発できます。 サードパーティの統合とライブラリが簡単で、すばやく簡単です。',
        },
        our_customers_heading: 'お客様',
        reviews_heading: '私たちのクライアントが言うこと',
        see_all_reviews: 'すべてのレビューを見る',
      },
      about: {
        main_heading: '私たちの物語',
        sub_heading:
          '私たちは、私たちが信じる人々のために誇りに思う作品をデザイン、作成、制作するために協力しています。',
        meet_the_team: 'チームに会う',
        team_description:
          '思いやり、独創性、細部へのこだわりは、私たちが設計、製造、販売するすべての製品の基盤です。',
        our_mission: '私たちの使命',
        mission_description:
          '私たちの使命は、ビジネスのトレンドと人々中心の文化と行動を重視する提案を重視する高品質のサービスと製品で、卓越したテクノロジーを広めることです。',
        our_activities: '私たちの活動',
        activities_description: '生計を立てるのに忙しくて、生計を立てることを忘れないでください。',
      },
    },
    menu: {
      home: '家',
      about: '約',
      inquiry: 'お問い合わせ',
      faq: 'よくあるご質問',
      dashboard: 'ダッシュボード',
      users: 'ユーザー',
      orders: '注文',
      reports: 'レポート',
      integrations: '統合',
      profile: 'プロフィール',
      logout: 'ログアウト',
      terms: '利用規約',
      privacy_policy: 'プライバシーポリシー',
      documentation: 'ドキュメンテーション',
      api_reference: 'APIリファレンス',
      support: 'サポート',
    },
  },
};

export default ja;
