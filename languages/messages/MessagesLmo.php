<?php
/** Lombard (lombard)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 *
 * @author Amgine
 * @author Clamengh
 * @author Dakrismeno
 * @author DracoRoboter
 * @author Flavio05
 * @author GatoSelvadego
 * @author Geitost
 * @author Insübrich
 * @author Kemmótar
 * @author Malafaya
 * @author Reedy
 * @author Remulazz
 * @author SabineCretella
 * @author Snowdog
 * @author Sprüngli
 * @author Gat lombart
 */

$fallback = 'pms, eml, lij, vec, it';

$namespaceNames = [
    NS_SPECIAL        => 'Special',
    NS_TALK           => 'Ciciarada',
    NS_USER           => 'Utent',
    NS_USER_TALK      => 'Ciciarada_Utent',
    NS_PROJECT_TALK   => 'Ciciarada_$1',
    NS_FILE           => 'Archivi',
    NS_FILE_TALK      => 'Ciciarada_Archivi',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'Ciciarada_MediaWiki',
    NS_TEMPLATE       => 'Modell',
    NS_TEMPLATE_TALK  => 'Ciciarada_Modell',
    NS_HELP           => 'Jut',
    NS_HELP_TALK      => 'Ciciarada_Jut',
    NS_CATEGORY       => 'Categoria',
    NS_CATEGORY_TALK  => 'Ciciarada_Categoria',
];

$namespaceAliases = [
    'Speciale'              => NS_SPECIAL,
    'Discussione'           => NS_TALK,
    'Utente'                => NS_USER,
    'Druvat'                => NS_USER,
    'Dovrat'                => NS_USER,
    'Druvadur'              => NS_USER,
    'Discussioni_utente'    => NS_USER_TALK,
    'Ciciarada_Druvat'      => NS_USER_TALK,
    'Ciciarada_Dovrat'      => NS_USER_TALK,
    'Ciciarada_Druvadur'    => NS_USER_TALK,
    '$1_Ciciarada'          => NS_PROJECT_TALK,
    'Discussioni_$1'        => NS_PROJECT_TALK,
    'Immagine'              => NS_FILE,
    'Discussioni_file'      => NS_FILE_TALK,
    'Discussioni_immagine'  => NS_FILE_TALK,
    'Discussioni_MediaWiki' => NS_MEDIAWIKI_TALK,
    'Model'                 => NS_TEMPLATE,
    'Mudel'                 => NS_TEMPLATE,
    'Discussioni_template'  => NS_TEMPLATE_TALK,
    'Ciciarada_Model'       => NS_TEMPLATE_TALK,
    'Ciciarada_Mudel'       => NS_TEMPLATE_TALK,
    'Aiuto'                 => NS_HELP,
    'Aida'                  => NS_HELP,
    'Jüt'                   => NS_HELP,
    'Discussioni_aiuto'     => NS_HELP_TALK,
    'Ciciarada_Aida'        => NS_HELP_TALK,
    'Ciciarada_Jüt'         => NS_HELP_TALK,
    'Categuria'             => NS_CATEGORY,
    'Discussioni_categoria' => NS_CATEGORY_TALK,
    'Ciciarada_Categuria'   => NS_CATEGORY_TALK,
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Allmessages'         => ['Messagg'],
    'BrokenRedirects'     => ['RedirezionS-cepada'],
    'Categories'          => ['Categurij'],
    'CreateAccount'       => ['CreaCünt'],
    'DoubleRedirects'     => ['RedirezionDubia'],
    'Listadmins'          => ['ListaAministradur'],
    'Listfiles'           => ['Imagin'],
    'Listgrouprights'     => ['Lista_di_dirit_di_grüp'],
    'Listusers'           => ['Dupradur'],
    'Lonelypages'         => ['PaginnDaPerLur'],
    'Newimages'           => ['ImaginNöv'],
    'Preferences'         => ['Preferenz'],
    'Randompage'          => ['PaginaAzardada'],
    'Recentchanges'       => ['CambiamentRecent'],
    'Recentchangeslinked' => ['MudifeghCulegaa'],
    'Specialpages'        => ['PaginnSpecial'],
    'Statistics'          => ['Statìstegh'],
    'Uncategorizedpages'  => ['PaginnMingaCategurizaa'],
    'Upload'              => ['CaregaSü'],
    'Userlogin'           => ['VenaDenter'],
    'Userlogout'          => ['VaFö'],
    'Watchlist'           => ['SutOeugg'],
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'img_left'  => ['1', 'manzína', 'sinistra', 'left'],
    'img_none'  => ['1', 'nissön', 'nessuno', 'none'],
    'img_right' => ['1', 'drita', 'destra', 'right'],
    'sitename'  => ['1', 'NUMSIT', 'NOMESITO', 'SITENAME'],
];
