<?php
/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

$fallback = 'nan, zh-hant, zh, zh-hans';

$namespaceNames = [
    NS_MEDIA          => '媒體',
    NS_SPECIAL        => '特殊',
    NS_TALK           => '討論',
    NS_USER           => '用戶',
    NS_USER_TALK      => '用戶討論',
    NS_PROJECT_TALK   => '$1討論',
    NS_FILE           => '文件',
    NS_FILE_TALK      => '文件討論',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'MediaWiki討論',
    NS_TEMPLATE       => '模板',
    NS_TEMPLATE_TALK  => '模板討論',
    NS_HELP           => '幫助',
    NS_HELP_TALK      => '幫助討論',
    NS_CATEGORY       => '分類',
    NS_CATEGORY_TALK  => '分類討論',
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Activeusers'             => ['活動用戶'],
    'Allmessages'             => ['全部信息'],
    'Allpages'                => ['全部頁面'],
    'Ancientpages'            => ['舊其頁面'],
    'Badtitle'                => ['呆其標題'],
    'Blankpage'               => ['空白頁面'],
    'Block'                   => ['封鎖', '封鎖IP', '封鎖用戶'],
    'BlockList'               => ['封鎖單'],
    'Booksources'             => ['圖書源'],
    'BrokenRedirects'         => ['呆其重定向'],
    'Categories'              => ['分類'],
    'ChangeEmail'             => ['改變電子郵件'],
    'ChangePassword'          => ['改變密碼', '重置密碼'],
    'ComparePages'            => ['比較頁面'],
    'Confirmemail'            => ['確認電子郵件'],
    'Contributions'           => ['貢獻'],
    'CreateAccount'           => ['開賬戶'],
    'DeletedContributions'    => ['刪唻其貢獻'],
    'DoubleRedirects'         => ['雙重重定向'],
    'EditWatchlist'           => ['修改監視單'],
    'Emailuser'               => ['共用戶發送電子郵件'],
    'Export'                  => ['導出'],
    'Fewestrevisions'         => ['最少其修訂'],
    'FileDuplicateSearch'     => ['文件重複尋討'],
    'Filepath'                => ['文件路徑'],
    'Import'                  => ['導底'],
    'Invalidateemail'         => ['無效電子郵件'],
    'JavaScriptTest'          => ['JavaScript測試'],
    'LinkSearch'              => ['鏈接尋討'],
    'Listadmins'              => ['管理員單單'],
    'Listbots'                => ['機器人單單'],
    'Listfiles'               => ['文件單', '圖片單'],
    'Listgrouprights'         => ['小組權限單', '用戶組單單'],
    'Listredirects'           => ['重定向單單'],
    'Listusers'               => ['用戶單'],
    'Lockdb'                  => ['鎖定數據庫'],
    'Log'                     => ['日誌'],
    'Lonelypages'             => ['單獨其頁面'],
    'Longpages'               => ['長長其頁面'],
    'MergeHistory'            => ['合併其歷史'],
    'MIMEsearch'              => ['MIME尋討'],
    'Mostcategories'          => ['最価其分類'],
    'Mostimages'              => ['最価鏈接其文件'],
    'Mostinterwikis'          => ['最稠其跨維基'],
    'Mostlinked'              => ['最価鏈接其頁面'],
    'Mostlinkedcategories'    => ['最価鏈接其分類'],
    'Mostlinkedtemplates'     => ['最価鏈接其模板'],
    'Mostrevisions'           => ['最稠其版本'],
    'Movepage'                => ['移動其頁面'],
    'Mycontributions'         => ['我其貢獻'],
    'MyLanguage'              => ['我其語言'],
    'Mypage'                  => ['我其頁面'],
    'Mytalk'                  => ['我其討論'],
    'Myuploads'               => ['我其上傳'],
    'Newimages'               => ['新其文件', '新其圖片'],
    'Newpages'                => ['新其頁面'],
    'PasswordReset'           => ['密碼重置'],
    'PermanentLink'           => ['永久鏈接'],
    'Preferences'             => ['喜好'],
    'Prefixindex'             => ['前綴索引'],
    'Protectedpages'          => ['受保護其頁面'],
    'Protectedtitles'         => ['受保護其標題'],
    'Randompage'              => ['隨便其頁面'],
    'Randomredirect'          => ['隨便其重定向'],
    'Recentchanges'           => ['最近其改變'],
    'Recentchangeslinked'     => ['最近改變其鏈接'],
    'Redirect'                => ['重定向'],
    'ResetTokens'             => ['重置令牌'],
    'Search'                  => ['尋討'],
    'Shortpages'              => ['短短其頁面'],
    'Specialpages'            => ['特殊頁'],
    'Statistics'              => ['統計'],
    'Tags'                    => ['標籤'],
    'Unblock'                 => ['取消封鎖'],
    'Uncategorizedcategories' => ['未分類其分類'],
    'Uncategorizedimages'     => ['未分類其文件', '未分類其圖片'],
    'Uncategorizedpages'      => ['未分類其頁面'],
    'Uncategorizedtemplates'  => ['未分類其模板'],
    'Undelete'                => ['伓使刪除'],
    'Unlockdb'                => ['解鎖數據庫'],
    'Unusedcategories'        => ['無乇使其分類'],
    'Unusedimages'            => ['無乇使其文件', '無乇使其圖片'],
    'Unusedtemplates'         => ['無乇使其模板'],
    'Unwatchedpages'          => ['未監視其頁面'],
    'Upload'                  => ['上傳'],
    'Userlogin'               => ['用戶躒底', '躒底'],
    'Userlogout'              => ['用戶躒出', '躒出'],
    'Userrights'              => ['用戶權限'],
    'Version'                 => ['版本'],
    'Wantedcategories'        => ['卜挃其分類'],
    'Wantedfiles'             => ['卜挃其文件'],
    'Wantedpages'             => ['卜挃其頁面'],
    'Wantedtemplates'         => ['卜挃其模板'],
    'Watchlist'               => ['監視單'],
    'Whatlinkshere'           => ['甚乇鏈遘嚽塊'],
    'Withoutinterwiki'        => ['無跨維基'],
];

$datePreferences = [
    'default',
    'ISO 8601',
];
$defaultDateFormat = 'cdo';
$dateFormats = [
    'cdo time' => 'H:i',
    'cdo date' => 'Y "nièng" n "nguŏk" j "hô̤" (l)',
    'cdo both' => 'Y "nièng" n "nguŏk" j "hô̤" (D) H:i',
];
