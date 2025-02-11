<?php
/** Basque (euskara)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

$namespaceNames = [
    NS_MEDIA          => 'Media',
    NS_SPECIAL        => 'Berezi',
    NS_TALK           => 'Eztabaida',
    NS_USER           => 'Lankide',
    NS_USER_TALK      => 'Lankide_eztabaida',
    NS_PROJECT_TALK   => '$1_eztabaida',
    NS_FILE           => 'Fitxategi',
    NS_FILE_TALK      => 'Fitxategi_eztabaida',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'MediaWiki_eztabaida',
    NS_TEMPLATE       => 'Txantiloi',
    NS_TEMPLATE_TALK  => 'Txantiloi_eztabaida',
    NS_HELP           => 'Laguntza',
    NS_HELP_TALK      => 'Laguntza_eztabaida',
    NS_CATEGORY       => 'Kategoria',
    NS_CATEGORY_TALK  => 'Kategoria_eztabaida',
];

$namespaceAliases = [
    'Aparteko'        => NS_SPECIAL,
    'Irudi'           => NS_FILE,
    'Irudi_eztabaida' => NS_FILE_TALK,
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Allmessages'             => ['MezuGuztiak'],
    'Allpages'                => ['OrrialdeGuztiak'],
    'Ancientpages'            => ['OrrialdeZaharrak'],
    'Blankpage'               => ['OrrialdeZuria'],
    'Block'                   => ['Blokeatu'],
    'BrokenRedirects'         => ['HautsitakoBirzuzenketak'],
    'Categories'              => ['Kategoriak'],
    'ChangePassword'          => ['PasahitzaAldatu'],
    'Confirmemail'            => ['EmailaBaieztatu'],
    'Contributions'           => ['Ekarpenak'],
    'CreateAccount'           => ['KontuaSortu'],
    'DoubleRedirects'         => ['BirzuzenketaBikoitzak'],
    'Emailuser'               => ['LankideEmaila'],
    'Export'                  => ['Esportatu'],
    'Import'                  => ['Inportatu'],
    'Listadmins'              => ['AdministratzaileZerrenda'],
    'Listbots'                => ['BotZerrenda'],
    'Listfiles'               => ['FitxategiZerrenda'],
    'Listusers'               => ['LankideZerrenda'],
    'Longpages'               => ['OrrialdeLuzeak'],
    'Movepage'                => ['OrrialdeaMugitu'],
    'Mycontributions'         => ['NireEkarpenak'],
    'Mypage'                  => ['NireOrrialdea'],
    'Mytalk'                  => ['NireEztabaida'],
    'Newimages'               => ['FitxategiBerriak'],
    'Newpages'                => ['OrrialdeBerriak'],
    'Preferences'             => ['Hobespenak'],
    'Protectedpages'          => ['BabestutakoOrrialdeak'],
    'Protectedtitles'         => ['BabestutakoIzenburuak'],
    'Randompage'              => ['Ausazkoa'],
    'Recentchanges'           => ['AzkenAldaketak'],
    'Search'                  => ['Bilatu'],
    'Shortpages'              => ['OrrialdeMotzak'],
    'Specialpages'            => ['OrrialdeBereziak'],
    'Statistics'              => ['Estatistikak'],
    'Tags'                    => ['Etiketak'],
    'Uncategorizedcategories' => ['KategorizatuGabekoKategoriak'],
    'Uncategorizedimages'     => ['KategorizatuGabekoFitxategiak'],
    'Uncategorizedpages'      => ['KategorizatuGabekoOrrialdeak'],
    'Uncategorizedtemplates'  => ['KategorizatuGabekoTxantiloiak'],
    'Upload'                  => ['Igo'],
    'Userlogin'               => ['SaioaHasi'],
    'Userlogout'              => ['SaioaItxi'],
    'Version'                 => ['Bertsioa'],
    'Wantedcategories'        => ['EskatutakoKategoriak'],
    'Wantedfiles'             => ['EskatutakoFitxategiak'],
    'Wantedpages'             => ['EskatutakoOrrialdeak'],
    'Wantedtemplates'         => ['EskatutakoTxantiloiak'],
    'Watchlist'               => ['JarraipenZerrenda'],
    'Whatlinkshere'           => ['ZerkLotzenDuHona'],
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'currentday'       => ['1', 'ORAINGOEGUN', 'CURRENTDAY'],
    'currentday2'      => ['1', 'ORAINGOEGUN2', 'CURRENTDAY2'],
    'currentdayname'   => ['1', 'ORAINGOEGUNIZEN', 'CURRENTDAYNAME'],
    'currentmonth'     => ['1', 'ORAINGOHILABETE', 'CURRENTMONTH', 'CURRENTMONTH2'],
    'currentmonthname' => ['1', 'ORAINGOHILABETEIZEN', 'CURRENTMONTHNAME'],
    'currentyear'      => ['1', 'ORAINGOURTE', 'CURRENTYEAR'],
    'img_center'       => ['1', 'erdian', 'center', 'centre'],
    'img_left'         => ['1', 'ezkerrera', 'left'],
    'img_right'        => ['1', 'eskuinera', 'right'],
    'numberofarticles' => ['1', 'ARTIKULUKOPURU', 'NUMBEROFARTICLES'],
    'numberofedits'    => ['1', 'ALDAKETAKOPURU', 'NUMBEROFEDITS'],
    'numberoffiles'    => ['1', 'FITXATEGIKOPURU', 'NUMBEROFFILES'],
    'numberofpages'    => ['1', 'ORRIALDEKOPURU', 'NUMBEROFPAGES'],
    'numberofusers'    => ['1', 'LANKIDEKOPURU', 'NUMBEROFUSERS'],
    'pagename'         => ['1', 'ORRIALDEIZEN', 'PAGENAME'],
    'redirect'         => ['0', '#BIRZUZENDU', '#REDIRECT'],
];

$separatorTransformTable = [',' => '.', '.' => ',']; /* T17717 */
