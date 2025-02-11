<?php
/** Javanese (Jawa)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

$fallback = 'id';

$namespaceNames = [
    NS_MEDIA          => 'Médhia',
    NS_SPECIAL        => 'Mirunggan',
    NS_TALK           => 'Parembugan',
    NS_USER           => 'Naraguna',
    NS_USER_TALK      => 'Parembugan_Naraguna',
    NS_PROJECT_TALK   => 'Parembugan_$1',
    NS_FILE           => 'Barkas',
    NS_FILE_TALK      => 'Parembugan_Barkas',
    NS_MEDIAWIKI      => 'MédhiaWiki',
    NS_MEDIAWIKI_TALK => 'Parembugan_MédhiaWiki',
    NS_TEMPLATE       => 'Cithakan',
    NS_TEMPLATE_TALK  => 'Parembugan_Cithakan',
    NS_HELP           => 'Pitulung',
    NS_HELP_TALK      => 'Parembugan_Pitulung',
    NS_CATEGORY       => 'Kategori',
    NS_CATEGORY_TALK  => 'Parembugan_Kategori',
];

$namespaceAliases = [ // Kept former namespaces for backwards compatibility - T155957
    'Cithakan_Dhiskusi'     => NS_TEMPLATE_TALK,
    'Dhiskusi'              => NS_TALK,
    'Dhiskusi_$1'           => NS_PROJECT_TALK,
    'Dhiskusi_Cithakan'     => NS_TEMPLATE_TALK,
    'Dhiskusi_Gambar'       => NS_FILE_TALK,
    'Dhiskusi_Kategori'     => NS_CATEGORY_TALK,
    'Dhiskusi_MediaWiki'    => NS_MEDIAWIKI_TALK,
    'Dhiskusi_Panganggo'    => NS_USER_TALK,
    'Dhiskusi_Pitulung'     => NS_HELP_TALK,
    'Kategori_Dhiskusi'     => NS_CATEGORY_TALK,
    'MediaWiki_Dhiskusi'    => NS_MEDIAWIKI_TALK,
    'Pitulung_Dhiskusi'     => NS_HELP_TALK,
    'Gambar_Dhiskusi'       => NS_FILE_TALK,
    'Astamiwa'              => NS_SPECIAL,
    'Panganggo'             => NS_USER,
    'Parembugan_Panganggo'  => NS_USER_TALK,
    'Gambar'                => NS_FILE,
    'Parembugan_Gambar'     => NS_FILE_TALK,
    'MediaWiki'             => NS_MEDIAWIKI,
    'Parembugan_MediaWiki'  => NS_MEDIAWIKI_TALK,
    'Media'                 => NS_MEDIA,
    'Medhia'                => NS_MEDIA,
    'MedhiaWiki'            => NS_MEDIAWIKI,
    'Parembugan_MedhiaWiki' => NS_MEDIAWIKI_TALK,
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Activeusers'             => ['Naraguna_giyat'],
    'Allmessages'             => ['Layang_sistem'],
    'AllMyUploads'            => ['Pratélan_unggahanku', 'Pratelan_unggahanku'],
    'Allpages'                => ['Pratélan_kaca', 'Pratelan_kaca'],
    'Ancientpages'            => ['Kaca_lawas'],
    'ApiHelp'                 => ['Pitulung_API'],
    'ApiSandbox'              => ['Bak_wedhi_API'],
    'AutoblockList'           => ['Pratélan_swapenggak', 'Pratelan_swapenggak'],
    'Badtitle'                => ['Sesirah_ala'],
    'Blankpage'               => ['Kaca_kosong'],
    'Block'                   => ['Penggak', 'Blokir'],
    'BlockList'               => ['Pratélan_penggak', 'Pratelan_penggak'],
    'Booksources'             => ['Sumber_buku'],
    'BotPasswords'            => ['Tembung_sandi_bot'],
    'BrokenRedirects'         => ['Alihan_rusak'],
    'Categories'              => ['Kategori'],
    'ChangeCredentials'       => ['Ganti_krédhénsiyal', 'Ganti_kredhensiyal'],
    'ChangeEmail'             => ['Ganti_layèl', 'Ganti_layel'],
    'ChangePassword'          => ['Ganti_sandi'],
    'ComparePages'            => ['Bandhingaké_kaca', 'Bandhingake_kaca'],
    'Confirmemail'            => ['Konfirmasi_layèl', 'Konfirmasi_layel'],
    'Contributions'           => ['Pasumbanging_naraguna'],
    'CreateAccount'           => ['Gawé_akun', 'Gawe_akun'],
    'Deadendpages'            => ['Kaca_buntu'],
    'DeletedContributions'    => ['Pasumbang_kang_dibusak'],
    'Diff'                    => ['Béda', 'Beda'],
    'DoubleRedirects'         => ['Alihan_dhobel'],
    'EditPage'                => ['Besut_kaca'],
    'EditTags'                => ['Besut_tenger'],
    'EditWatchlist'           => ['Besut_pawawangan'],
    'Emailuser'               => ['Layèl_naraguna', 'Layel_naraguna'],
    'ExpandTemplates'         => ['Jembaraké_cithakan', 'Jembarake_cithakan'],
    'Export'                  => ['Èspor_kaca', 'Espor_kaca'],
    'Fewestrevisions'         => ['Owahan_sathithik_dhéwé', 'Owahan_sathithik_dhewe'],
    'FileDuplicateSearch'     => ['Golèk_barkas_dhobel', 'Golek_barkas_dhobel'],
    'Filepath'                => ['Pernahing_barkas'],
    'GoToInterwiki'           => ['Menyang_interwiki'],
    'Import'                  => ['Impor_kaca'],
    'Invalidateemail'         => ['Wurung_validhasi_layèl', 'Wurung_validhasi_layel'],
    'JavaScriptTest'          => ['Jajal_JavaScript'],
    'LinkSearch'              => ['Golèk_pranala', 'Golek_pranala'],
    'Listadmins'              => ['Pratélan_panata', 'Pratelan_panata'],
    'Listbots'                => ['Pratélan_bot', 'Pratelan_bot'],
    'ListDuplicatedFiles'     => ['Pratélan_barkas_dhobel', 'Pratelan_barkas_dhobel'],
    'Listfiles'               => ['Pratélan_barkas', 'Pratelan_barkas'],
    'Listgrants'              => ['Pratélan_idin', 'Pratelan_idin'],
    'Listgrouprights'         => ['Pratélan_hak_golongan', 'Pratelan_hak_golongan'],
    'Listredirects'           => ['Pratélan_alihan', 'Pratelan_alihan'],
    'Listusers'               => ['Pratélan_naraguna', 'Pratelan_naraguna'],
    'Lockdb'                  => ['Gembok_basis_dhata'],
    'Log'                     => ['Cathetan'],
    'Lonelypages'             => ['Kaca_lola'],
    'Longpages'               => ['Kaca_dawa'],
    'MediaStatistics'         => ['Setatistik_médhia', 'Setatistik_medhia'],
    'MergeHistory'            => ['Sajarahing_panggabung'],
    'MIMEsearch'              => ['Golèk_MIME', 'Golek_MIME'],
    'Mostcategories'          => ['Kategori_akèh_dhéwé', 'Kategori_akeh_dhewe'],
    'Mostimages'              => ['Gambar_akèh_dhéwé', 'Gambar_akeh_dhewe'],
    'Mostinterwikis'          => ['Interwiki_akèh_dhéwé', 'Interwiki_akeh_dhewe'],
    'Mostlinked'              => ['Kaca_akèh_dhéwé_kagayut', 'Kaca_akeh_dhewe_kagayut'],
    'Mostlinkedcategories'    => ['Kategori_akèh_dhéwé_kagayut', 'Kategori_akeh_dhewe_kagayut'],
    'Mostlinkedtemplates'     => ['Cithakan_akèh_dhéwé_kagayut', 'Cithakan_akeh_dhewe_kagayut'],
    'Mostrevisions'           => ['Owahan_akèh_dhéwé', 'Owahan_akeh_dhewe'],
    'Movepage'                => ['Lih_kaca'],
    'Mute'                    => ['Bisu'],
    'Mycontributions'         => ['Pasumbangku'],
    'MyLanguage'              => ['Basaku'],
    'Mypage'                  => ['Kacaku'],
    'Mytalk'                  => ['Parembuganku'],
    'Myuploads'               => ['Unggahanku'],
    'Newimages'               => ['Gambar_anyar'],
    'Newpages'                => ['Kaca_anyar'],
    'NewSection'              => ['Pérangan_anyar', 'Perangan_anyar'],
    'PageData'                => ['Dhata_kaca'],
    'PageHistory'             => ['Sajarahing_kaca', 'Sajarah'],
    'PageInfo'                => ['Katerangan_kaca', 'Katerangan'],
    'PageLanguage'            => ['Basaning_kaca'],
    'PasswordPolicies'        => ['Niti_tembung_sandi'],
    'PasswordReset'           => ['Balèni_setèl_sandi', 'Baleni_setel_sandi'],
    'PermanentLink'           => ['Pranala_permanèn', 'Pranala_permanen'],
    'Preferences'             => ['Pilalan'],
    'Prefixindex'             => ['Indhèk_ater-ater', 'Indhek_ater-ater'],
    'Protectedpages'          => ['Kaca_direksa'],
    'Protectedtitles'         => ['Sesirah_direksa'],
    'Purge'                   => ['Resiki'],
    'RandomInCategory'        => ['Sembarang_ing_kategori'],
    'Randompage'              => ['Kaca_sembarang'],
    'Randomredirect'          => ['Alihan_sembarang'],
    'Randomrootpage'          => ['Kaca_oyod_sembarang'],
    'Recentchanges'           => ['Owahan_anyar'],
    'Recentchangeslinked'     => ['Owahan_magepokan'],
    'Redirect'                => ['Alihan'],
    'RemoveCredentials'       => ['Busak_krédhénsiyal', 'Busak_kredhensiyal'],
    'ResetTokens'             => ['Balèni_setèl_token', 'Baleni_setel_token'],
    'Revisiondelete'          => ['Busak_révisi', 'Busak_revisi'],
    'Search'                  => ['Golèk', 'Golek'],
    'Shortpages'              => ['Kaca_cendhak'],
    'Specialpages'            => ['Kaca_mirunggan'],
    'Statistics'              => ['Setatistik'],
    'Tags'                    => ['Tenger'],
    'TrackingCategories'      => ['Kategori_panglacak'],
    'Unblock'                 => ['Copot_penggakan'],
    'Uncategorizedcategories' => ['Kategori_kang_tanpa_kategori'],
    'Uncategorizedimages'     => ['Gambar_kang_tanpa_kategori'],
    'Uncategorizedpages'      => ['Kaca_kang_tanpa_kategori'],
    'Uncategorizedtemplates'  => ['Cithakan_kang_tanpa_kategori'],
    'Undelete'                => ['Wurung_mbusak'],
    'Unlockdb'                => ['Bukak_gemboking_basis_dhata'],
    'Unusedcategories'        => ['Kategori_kang_ora_kaanggo'],
    'Unusedimages'            => ['Gambar_kang_ora_kaanggo'],
    'Unusedtemplates'         => ['Cithakan_kang_ora_kaanggo'],
    'Unwatchedpages'          => ['Kaca_kang_ora_ingawasan'],
    'Upload'                  => ['Unggah'],
    'Userlogin'               => ['Mlebu_log', 'Login'],
    'Userlogout'              => ['Metu_log', 'Logout'],
    'Userrights'              => ['Hak_naraguna'],
    'Version'                 => ['Gagrag'],
    'Wantedcategories'        => ['Kategori_kang_dipéngini', 'Kategori_kang_dipengini'],
    'Wantedfiles'             => ['Barkas_kang_dipéngini', 'Barkas_kang_dipengini'],
    'Wantedpages'             => ['Kaca_kang_dipéngini', 'Kaca_kang_dipengini'],
    'Wantedtemplates'         => ['Cithakan_kang_dipéngini', 'Cithakan_kang_dipengini'],
    'Watchlist'               => ['Pawawangan'],
    'Whatlinkshere'           => ['Pranala_mréné', 'Pranala_mrene'],
    'Withoutinterwiki'        => ['Tanpa_interwiki'],
];
