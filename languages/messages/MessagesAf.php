<?php
/** Afrikaans (Afrikaans)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

$namespaceNames = [
    NS_MEDIA          => 'Media',
    NS_SPECIAL        => 'Spesiaal',
    NS_TALK           => 'Bespreking',
    NS_USER           => 'Gebruiker',
    NS_USER_TALK      => 'Gebruikerbespreking',
    NS_PROJECT_TALK   => '$1bespreking',
    NS_FILE           => 'Lêer',
    NS_FILE_TALK      => 'Lêerbespreking',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'MediaWikibespreking',
    NS_TEMPLATE       => 'Sjabloon',
    NS_TEMPLATE_TALK  => 'Sjabloonbespreking',
    NS_HELP           => 'Hulp',
    NS_HELP_TALK      => 'Hulpbespreking',
    NS_CATEGORY       => 'Kategorie',
    NS_CATEGORY_TALK  => 'Kategoriebespreking',
];

$namespaceAliases = [
    'Beeld'           => NS_FILE,
    'Beeldbespreking' => NS_FILE_TALK,
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'currentday'          => ['1', 'HUIDIGEDAG', 'CURRENTDAY'],
    'currentday2'         => ['1', 'HUIDIGEDAG2', 'CURRENTDAY2'],
    'currentdayname'      => ['1', 'HUIDIGEDAGNAAM', 'CURRENTDAYNAME'],
    'currenthour'         => ['1', 'HUIDIGEUUR', 'CURRENTHOUR'],
    'currentmonth'        => ['1', 'HUIDIGEMAAND', 'CURRENTMONTH', 'CURRENTMONTH2'],
    'currentmonth1'       => ['1', 'HUIDIGEMAAND1', 'CURRENTMONTH1'],
    'currentmonthabbrev'  => ['1', 'HUIDIGEMAANDAFK', 'CURRENTMONTHABBREV'],
    'currentmonthname'    => ['1', 'HUIDIGEMAANDNAAM', 'CURRENTMONTHNAME'],
    'currenttime'         => ['1', 'HUIDIGETYD', 'CURRENTTIME'],
    'currentversion'      => ['1', 'HUIDIGEWEERGAWE', 'CURRENTVERSION'],
    'currentyear'         => ['1', 'HUIDIGEJAAR', 'CURRENTYEAR'],
    'displaytitle'        => ['1', 'VERTOONTITEL', 'DISPLAYTITLE'],
    'filepath'            => ['0', 'LêERPAD:', 'FILEPATH:'],
    'forcetoc'            => ['0', '__DWINGIO__', '__FORCETOC__'],
    'fullpagename'        => ['1', 'VOLBLADSYNAAM', 'FULLPAGENAME'],
    'fullurl'             => ['0', 'VOLURL', 'FULLURL:'],
    'gender'              => ['0', 'GESLAG:', 'GENDER:'],
    'img_border'          => ['1', 'raam', 'border'],
    'img_bottom'          => ['1', 'onder', 'bottom'],
    'img_center'          => ['1', 'senter', 'center', 'centre'],
    'img_framed'          => ['1', 'omraam', 'frame', 'framed', 'enframed'],
    'img_frameless'       => ['1', 'raamloos', 'frameless'],
    'img_left'            => ['1', 'links', 'left'],
    'img_link'            => ['1', 'skakel=$1', 'link=$1'],
    'img_middle'          => ['1', 'middel', 'middle'],
    'img_none'            => ['1', 'geen', 'none'],
    'img_right'           => ['1', 'regs', 'right'],
    'img_text_bottom'     => ['1', 'teks-onder', 'text-bottom'],
    'img_text_top'        => ['1', 'teks-bo', 'text-top'],
    'img_thumbnail'       => ['1', 'duimnael', 'thumb', 'thumbnail'],
    'img_top'             => ['1', 'bo', 'top'],
    'index'               => ['1', '__INDEKS__', '__INDEX__'],
    'language'            => ['0', '#TAAL:', '#LANGUAGE:'],
    'localweek'           => ['1', 'HUIDIGEWEEK', 'LOCALWEEK'],
    'namespace'           => ['1', 'NAAMSPASIE', 'NAMESPACE'],
    'noeditsection'       => ['0', '__GEENNUWEAFDELING__', '__NOEDITSECTION__'],
    'nogallery'           => ['0', '__GEENGALERY__', '__NOGALLERY__'],
    'noindex'             => ['1', '__GEENINDEKS__', '__NOINDEX__'],
    'notoc'               => ['0', '__GEENIO__', '__NOTOC__'],
    'numberofactiveusers' => ['1', 'AANTALAKTIEWEGEBRUIKERS', 'NUMBEROFACTIVEUSERS'],
    'numberofarticles'    => ['1', 'AANTALARTIKELS', 'NUMBEROFARTICLES'],
    'numberofedits'       => ['1', 'AANTALWYSIGINGS', 'NUMBEROFEDITS'],
    'numberoffiles'       => ['1', 'AANTALLêERS', 'NUMBEROFFILES'],
    'numberofpages'       => ['1', 'AANTALBLADSYE', 'NUMBEROFPAGES'],
    'numberofusers'       => ['1', 'AANTALGEBRUIKERS', 'NUMBEROFUSERS'],
    'pagename'            => ['1', 'BLADSYNAAM', 'PAGENAME'],
    'pagesize'            => ['1', 'BLADSYGROOTTE', 'PAGESIZE'],
    'plural'              => ['0', 'MEERVOUD', 'PLURAL:'],
    'redirect'            => ['0', '#AANSTUUR', '#REDIRECT'],
    'server'              => ['0', 'BEDIENER', 'SERVER'],
    'servername'          => ['0', 'BEDIENERNAAM', 'SERVERNAME'],
    'sitename'            => ['1', 'WERFNAAM', 'SITENAME'],
    'special'             => ['0', 'spesiaal', 'special'],
    'tag'                 => ['0', 'etiket', 'tag'],
    'talkspace'           => ['1', 'BESPREKINGSBLADSY', 'TALKSPACE'],
    'toc'                 => ['0', '__IO__', '__TOC__'],
    'url_path'            => ['0', 'PAD', 'PATH'],
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Activeusers'             => ['AktieweGebruikers'],
    'Allmessages'             => ['Stelselboodskappe', 'Alle_stelselboodskappe', 'Allestelselboodskappe', 'Boodskappe'],
    'AllMyUploads'            => ['AlMyOplaaie', 'AlMyLêers'],
    'Allpages'                => ['Alle_bladsye', 'Allebladsye'],
    'Ancientpages'            => ['OuBladsye'],
    'Badtitle'                => ['Slegtetitel'],
    'Blankpage'               => ['SkoonBladsy'],
    'Block'                   => ['BlokIP'],
    'BlockList'               => ['IPBlokLys'],
    'Booksources'             => ['Boekbronne'],
    'BrokenRedirects'         => ['Stukkende_aansture', 'Stukkendeaansture'],
    'Categories'              => ['Kategorieë'],
    'ChangeEmail'             => ['VeranderEpos'],
    'ChangePassword'          => ['HerstelWagwoord'],
    'ComparePages'            => ['VergelykBladsye'],
    'Confirmemail'            => ['Bevestig_e-posadres', 'Bevestige-posadres', 'Bevestig_eposadres', 'Bevestigeposadres'],
    'Contributions'           => ['Bydraes', 'Gebruikersbydraes'],
    'CreateAccount'           => ['SkepRekening', 'MaakGebruiker'],
    'Deadendpages'            => ['DoodloopBladsye'],
    'DeletedContributions'    => ['GeskrapteBydraes'],
    'DoubleRedirects'         => ['Dubbele_aansture', 'Dubbeleaansture'],
    'Emailuser'               => ['Stuur_e-pos', 'Stuure-pos', 'Stuur_epos', 'Stuurepos'],
    'Export'                  => ['Eksporteer'],
    'Fewestrevisions'         => ['MinsteWysigings'],
    'FileDuplicateSearch'     => ['LerDuplikaatSoek'],
    'Filepath'                => ['Lêerpad'],
    'Import'                  => ['Importeer'],
    'Invalidateemail'         => ['OngeldigeEpos'],
    'JavaScriptTest'          => ['JavaScriptToets'],
    'LinkSearch'              => ['SkakelSoektog'],
    'Listadmins'              => ['LysAdministrateurs'],
    'Listbots'                => ['LysRobotte'],
    'Listfiles'               => ['Beeldelys', 'Prentelys', 'Lêerslys'],
    'Listgrouprights'         => ['LysGroepRegte'],
    'Listredirects'           => ['LysAansture'],
    'Listusers'               => ['Gebruikerslys', 'Lysgebruikers'],
    'Lockdb'                  => ['SluitDB'],
    'Log'                     => ['Logboek', 'Logboeke'],
    'Lonelypages'             => ['EensaamBladsye'],
    'Longpages'               => ['LangBladsye'],
    'MergeHistory'            => ['VersmeltGeskiedenis'],
    'MIMEsearch'              => ['MIME-soek', 'MIMEsoek', 'MIME_soek'],
    'Mostcategories'          => ['MeesteKategorieë'],
    'Mostimages'              => ['MeesteBeelde'],
    'Mostinterwikis'          => ['MeesteInterwikis'],
    'Mostlinked'              => ['MeesteGeskakel'],
    'Mostlinkedcategories'    => ['MeesGeskakeldeKategorieë'],
    'Mostlinkedtemplates'     => ['MeesGeskakeldeSjablone'],
    'Mostrevisions'           => ['MeesteWysigings'],
    'Movepage'                => ['Skuif_bladsy', 'Skuifbladsy'],
    'Mycontributions'         => ['Mybydrae'],
    'MyLanguage'              => ['MyTaal'],
    'Mypage'                  => ['MyBladsy'],
    'Mytalk'                  => ['Mybespreking', 'Mybesprekings'],
    'Myuploads'               => ['MyOplaaie', 'MyLêers'],
    'Newimages'               => ['Nuwe_beelde', 'Nuwebeelde', 'Nuwe_lêers', 'Nuwelêers'],
    'Newpages'                => ['Nuwe_bladsye', 'Nuwebladsye'],
    'PasswordReset'           => ['WagwoordHerstel'],
    'Preferences'             => ['Voorkeure'],
    'Prefixindex'             => ['VoorvoegselIndeks'],
    'Protectedpages'          => ['BeskermdeBladsye'],
    'Protectedtitles'         => ['BeskermdeTitels'],
    'Randompage'              => ['Lukraak', 'Lukrakebladsy'],
    'Randomredirect'          => ['Lukrake_aanstuur', 'Lukrakeaanstuur'],
    'Recentchanges'           => ['Onlangse_wysigings', 'Onlangsewysigings'],
    'Recentchangeslinked'     => ['OnlangseVeranderingsMetSkakels', 'VerwanteVeranderings'],
    'Redirect'                => ['Aanstuur'],
    'Revisiondelete'          => ['WeergaweSkrap'],
    'Search'                  => ['Soek'],
    'Shortpages'              => ['KortBladsye'],
    'Specialpages'            => ['Spesiale_bladsye', 'Spesialebladsye'],
    'Statistics'              => ['Statistiek'],
    'Tags'                    => ['Etikette'],
    'Unblock'                 => ['Deblokkeer'],
    'Uncategorizedcategories' => ['OngekategoriseerdeKategorieë'],
    'Uncategorizedimages'     => ['OngekategoriseerdeBeelde'],
    'Uncategorizedpages'      => ['OngekategoriseerdeBladsye'],
    'Uncategorizedtemplates'  => ['OngekategoriseerdeSjablone'],
    'Undelete'                => ['Ontskrap'],
    'Unlockdb'                => ['OntsluitDB'],
    'Unusedcategories'        => ['OngebruikdeKategorieë'],
    'Unusedimages'            => ['OngebruikdeBeelde'],
    'Unusedtemplates'         => ['OngebruikteSjablone'],
    'Unwatchedpages'          => ['NieDopgehoudeBladsye'],
    'Upload'                  => ['Laai', 'Oplaai'],
    'Userlogin'               => ['Teken_in', 'Tekenin'],
    'Userlogout'              => ['Teken_uit', 'Tekenuit'],
    'Userrights'              => ['GebruikersRegte'],
    'Version'                 => ['Weergawe'],
    'Wantedcategories'        => ['GesoekteKategorieë'],
    'Wantedfiles'             => ['GesoekteLêers'],
    'Wantedpages'             => ['GesoekteBladsye', 'GebreekteSkakels'],
    'Wantedtemplates'         => ['GesoekteSjablone'],
    'Watchlist'               => ['Dophoulys'],
    'Whatlinkshere'           => ['Skakels_hierheen', 'Skakelshierheen'],
    'Withoutinterwiki'        => ['Sonder_taalskakels', 'Sondertaalskakels'],
];

# South Africa uses space for thousands and comma for decimal
# Reference: AWS Reël 7.4 p. 52, 2002 edition
# glibc is wrong in this respect in some versions
$separatorTransformTable = [',' => "\u{00A0}", '.' => ','];
$linkTrail = "/^([a-z]+)(.*)$/sD";
