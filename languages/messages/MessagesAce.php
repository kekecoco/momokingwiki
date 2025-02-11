<?php
/** Achinese (Acèh)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

$fallback = 'id';

$namespaceNames = [
    NS_MEDIA          => 'Alat',
    NS_SPECIAL        => 'Kusuih',
    NS_TALK           => 'Marit',
    NS_USER           => 'Ureuëng_Ngui',
    NS_USER_TALK      => 'Marit_Ureuëng_Ngui',
    NS_PROJECT_TALK   => 'Marit_$1',
    NS_FILE           => 'Beureukaih',
    NS_FILE_TALK      => 'Marit_Beureukaih',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'Marit_MediaWiki',
    NS_TEMPLATE       => 'Seunaleuëk',
    NS_TEMPLATE_TALK  => 'Marit_Seunaleuëk',
    NS_HELP           => 'Beunantu',
    NS_HELP_TALK      => 'Marit_Beunantu',
    NS_CATEGORY       => 'Kawan',
    NS_CATEGORY_TALK  => 'Marit_Kawan',
];

$namespaceAliases = [
    'Istimewa'              => NS_SPECIAL,
    'Bicara'                => NS_TALK,
    'Pembicaraan'           => NS_TALK,
    'Pengguna'              => NS_USER,
    'Bicara_Pengguna'       => NS_USER_TALK,
    'Ureuëng_Nguy'          => NS_USER,
    'Marit_Ureuëng_Nguy'    => NS_USER_TALK,
    'Pembicaraan_Pengguna'  => NS_USER_TALK,
    'Pembicaraan_$1'        => NS_PROJECT_TALK,
    'Berkas'                => NS_FILE,
    'Gambar'                => NS_FILE,
    'Pembicaraan_Berkas'    => NS_FILE_TALK,
    'Pembicaraan_Gambar'    => NS_FILE_TALK,
    'AlatWiki'              => NS_MEDIAWIKI,
    'Marit_AlatWiki'        => NS_MEDIAWIKI_TALK,
    'Pembicaraan_MediaWiki' => NS_MEDIAWIKI_TALK,
    'MediaWiki_Pembicaraan' => NS_MEDIAWIKI_TALK,
    'Templat'               => NS_TEMPLATE,
    'Pembicaraan_Templat'   => NS_TEMPLATE_TALK,
    'Templat_Pembicaraan'   => NS_TEMPLATE_TALK,
    'Pola'                  => NS_TEMPLATE,
    'Marit_Pola'            => NS_TEMPLATE_TALK,
    'Bantuan'               => NS_HELP,
    'Bantuan_Pembicaraan'   => NS_HELP_TALK,
    'Pembicaraan_Bantuan'   => NS_HELP_TALK,
    'Kategori'              => NS_CATEGORY,
    'Kategori_Pembicaraan'  => NS_CATEGORY_TALK,
    'Pembicaraan_Kategori'  => NS_CATEGORY_TALK,
    'Gambar_Pembicaraan'    => NS_FILE_TALK,
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'redirect' => ['0', '#PUPINAH', '#ALIH', '#REDIRECT'],
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Activeusers'             => ['UreuëngNguiUdép'],
    'Allmessages'             => ['BanDumPeusan'],
    'AllMyUploads'            => ['BanDumPeunasoëLôn', 'BanDumBeureukaihLôn'],
    'Allpages'                => ['DapeutaLaman'],
    'Ancientpages'            => ['TeunuléhAwai'],
    'Badtitle'                => ['NanBrôk'],
    'Blankpage'               => ['LamanSoh'],
    'Block'                   => ['TheunUreuëngNgui'],
    'BlockList'               => ['DapeutaTeuneuheun'],
    'Booksources'             => ['NèKitab'],
    'BrokenRedirects'         => ['PeuninahReuloh'],
    'Categories'              => ['DapeutaKawan'],
    'ChangePassword'          => ['GantoëLageuëmRahsia'],
    'Confirmemail'            => ['PeunyoSurat-e'],
    'Contributions'           => ['BeuneuriUreuëngNgui'],
    'CreateAccount'           => ['PeugötNan'],
    'Deadendpages'            => ['ÔnMaté'],
    'DeletedContributions'    => ['BeuneuriNyangGeusampôh'],
    'DoubleRedirects'         => ['PeuninahGanda'],
    'Emailuser'               => ['Surat-eUreuëngNgui'],
    'Export'                  => ['Peuteubiët'],
    'Fewestrevisions'         => ['NeuubahPaléngDit'],
    'FileDuplicateSearch'     => ['MitaBeureukaihSaban'],
    'Filepath'                => ['NeuduëkBeureukaih'],
    'Import'                  => ['Peutamöng'],
    'Invalidateemail'         => ['PeubateuëPeusahSurat-e'],
    'LinkSearch'              => ['MitaPeunawôt'],
    'Listadmins'              => ['DapeutaUreuëngUrôh'],
    'Listbots'                => ['DapeutaBot'],
    'Listfiles'               => ['DapeutaBeureukaih'],
    'Listgrouprights'         => ['DapeutaHakKawan'],
    'Listredirects'           => ['DapeutaPeuninah'],
    'Listusers'               => ['DapeutaUreuëngNgui'],
    'Lockdb'                  => ['GunciBasisData'],
    'Lonelypages'             => ['On_hana_soe_po'],
    'Longpages'               => ['On_panyang'],
    'MergeHistory'            => ['Riwayat_peusapat'],
    'MIMEsearch'              => ['Mita_MIME'],
    'Mostcategories'          => ['Kawan_paleng_le'],
    'Mostimages'              => ['Beureukaih_nyang_paleng_le_geunguy'],
    'Mostlinked'              => ['On_nyang_paleng_le_geunguy'],
    'Mostlinkedcategories'    => ['Kawan_nyang_paleng_le_geunguy'],
    'Mostlinkedtemplates'     => ['Templat_nyang_paleng_le_geunguy'],
    'Mostrevisions'           => ['Neuubah_paleng_le'],
    'Movepage'                => ['Peupinah_on'],
    'Mycontributions'         => ['Atra_lon_peugot'],
    'Mypage'                  => ['On_lon'],
    'Mytalk'                  => ['Peugah_haba_lon'],
    'Newimages'               => ['Beureukaih_baro'],
    'Newpages'                => ['On_baro'],
    'Preferences'             => ['Geunalak'],
    'Prefixindex'             => ['Dapeuta_neuaway'],
    'Protectedpages'          => ['On_nyang_geupeulindong'],
    'Protectedtitles'         => ['Nan_nyang_geupeulindong'],
    'Randompage'              => ['On_beurangkari'],
    'Randomredirect'          => ['Peuninah_beurangkari'],
    'Recentchanges'           => ['Neuubah_baro'],
    'Recentchangeslinked'     => ['Neuubah_meuhubong'],
    'Revisiondelete'          => ['Sampoh_peugot_ulang'],
    'Search'                  => ['Mita'],
    'Shortpages'              => ['On_paneuek'],
    'Specialpages'            => ['On_khusoih'],
    'Statistics'              => ['Keunira'],
    'Tags'                    => ['Tag'],
    'Uncategorizedcategories' => ['Kawan_hana_roh_lam_kawan'],
    'Uncategorizedimages'     => ['Beureukaih_hana_roh_lam_kawan'],
    'Uncategorizedpages'      => ['On_hana_roh_lam_kawan'],
    'Uncategorizedtemplates'  => ['Templat_hana_roh_lam_kawan'],
    'Undelete'                => ['Peubateue_sampoh'],
    'Unlockdb'                => ['Peuhah_gunci_basis_data'],
    'Unusedcategories'        => ['Kawan_soh'],
    'Unusedimages'            => ['Beureukaih_hana_teunguy'],
    'Unusedtemplates'         => ['Templat_hana_soe_nguy'],
    'Unwatchedpages'          => ['On_hana_soe_kalon'],
    'Upload'                  => ['Pasoe'],
    'Userlogin'               => ['Tamong_log'],
    'Userlogout'              => ['Teubiet_log'],
    'Userrights'              => ['Khut_(hak)_ureueng_nguy'],
    'Version'                 => ['Seunalen'],
    'Wantedcategories'        => ['Kawan_nyang_geuh\'eut'],
    'Wantedfiles'             => ['Beureukaih_nyang_geuh\'eut'],
    'Wantedpages'             => ['On_nyang_geuh\'eut'],
    'Wantedtemplates'         => ['Templat_nyang_geuh\'eut'],
    'Watchlist'               => ['Dapeuta_kalon'],
    'Whatlinkshere'           => ['Hubong_gisa'],
    'Withoutinterwiki'        => ['Hana_interwiki'],
];
