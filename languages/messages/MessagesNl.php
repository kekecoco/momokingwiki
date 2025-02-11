<?php
/** Dutch (Nederlands)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 *
 * @author Annabel
 * @author Arent
 * @author AvatarTeam
 * @author B4bol4t
 * @author Basvb
 * @author Breghtje
 * @author DasRakel
 * @author Effeietsanders
 * @author Erwin
 * @author Erwin85
 * @author Extended by Hendrik Maryns <hendrik.maryns@uni-tuebingen.de>, March 2007.
 * @author Flightmare
 * @author Fryed-peach
 * @author Galwaygirl
 * @author Geitost
 * @author GerardM
 * @author Hamaryns
 * @author HanV
 * @author Hansmuller
 * @author Jens Liebenau
 * @author JurgenNL
 * @author Kaganer
 * @author Kippenvlees1
 * @author Krinkle
 * @author MarkvA
 * @author McDutchie
 * @author Mihxil
 * @author Multichill
 * @author Mwpnl
 * @author Naudefj
 * @author Niels
 * @author Niknetniko
 * @author Paul B
 * @author Romaine
 * @author SPQRobin
 * @author Saruman
 * @author Servien
 * @author Siebrand
 * @author Sjoerddebruin
 * @author Slomox
 * @author Southparkfan
 * @author TBloemink
 * @author Tedjuh10
 * @author Tjcool007
 * @author Trijnstel
 * @author Troefkaart
 * @author Tvdm
 * @author User555
 * @author Vogone
 * @author WTM
 * @author Wiki13
 * @author Wikiklaas
 * @author Wolf Lambert
 * @author לערי ריינהארט
 */

$separatorTransformTable = [',' => '.', '.' => ','];

$namespaceNames = [
    NS_MEDIA          => 'Media',
    NS_SPECIAL        => 'Speciaal',
    NS_TALK           => 'Overleg',
    NS_USER           => 'Gebruiker',
    NS_USER_TALK      => 'Overleg_gebruiker',
    NS_PROJECT_TALK   => 'Overleg_$1',
    NS_FILE           => 'Bestand',
    NS_FILE_TALK      => 'Overleg_bestand',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'Overleg_MediaWiki',
    NS_TEMPLATE       => 'Sjabloon',
    NS_TEMPLATE_TALK  => 'Overleg_sjabloon',
    NS_HELP           => 'Help',
    NS_HELP_TALK      => 'Overleg_help',
    NS_CATEGORY       => 'Categorie',
    NS_CATEGORY_TALK  => 'Overleg_categorie',
];

$namespaceAliases = [
    'Afbeelding'         => NS_FILE,
    'Overleg_afbeelding' => NS_FILE_TALK,
];

$datePreferences = [
    'default',
    'dmy',
    'ymd',
    'ISO 8601',
];

$defaultDateFormat = 'dmy';

$dateFormats = [
    'dmy time' => 'H:i',
    'dmy date' => 'j M Y',
    'dmy both' => 'j M Y H:i',

    'ymd time' => 'H:i',
    'ymd date' => 'Y M j',
    'ymd both' => 'Y M j H:i',
];

$bookstoreList = [
    'Koninklijke Bibliotheek' => 'http://opc4.kb.nl/DB=1/SET=5/TTL=1/CMD?ACT=SRCH&IKT=1007&SRT=RLV&TRM=$1'
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'anchorencode'            => ['0', 'ANKERCODEREN', 'CODEERANKER', 'ANCHORENCODE'],
    'articlepath'             => ['0', 'ARTIKELPAD', 'ARTICLEPATH'],
    'basepagename'            => ['1', 'BASISPAGINANAAM', 'BASEPAGENAME'],
    'basepagenamee'           => ['1', 'BASISPAGINANAAME', 'BASEPAGENAMEE'],
    'canonicalurl'            => ['0', 'CANOIEKEURL:', 'CANONICALURL:'],
    'canonicalurle'           => ['0', 'CANONIEKEURLE:', 'CANONICALURLE:'],
    'contentlanguage'         => ['1', 'INHOUDSTAAL', 'INHOUDTAAL', 'CONTENTLANGUAGE', 'CONTENTLANG'],
    'currentday'              => ['1', 'HUIDIGEDAG', 'CURRENTDAY'],
    'currentday2'             => ['1', 'HUIDIGEDAG2', 'CURRENTDAY2'],
    'currentdayname'          => ['1', 'HUIDIGEDAGNAAM', 'CURRENTDAYNAME'],
    'currentdow'              => ['1', 'HUIDIGEDVDW', 'CURRENTDOW'],
    'currenthour'             => ['1', 'HUIDIGUUR', 'CURRENTHOUR'],
    'currentmonth'            => ['1', 'HUIDIGEMAAND', 'HUIDIGEMAAND2', 'CURRENTMONTH', 'CURRENTMONTH2'],
    'currentmonth1'           => ['1', 'HUIDIGEMAAND1', 'CURRENTMONTH1'],
    'currentmonthabbrev'      => ['1', 'HUIDIGEMAANDAFK', 'CURRENTMONTHABBREV'],
    'currentmonthname'        => ['1', 'HUIDIGEMAANDNAAM', 'CURRENTMONTHNAME'],
    'currentmonthnamegen'     => ['1', 'HUIDIGEMAANDGEN', 'CURRENTMONTHNAMEGEN'],
    'currenttime'             => ['1', 'HUIDIGETIJD', 'CURRENTTIME'],
    'currenttimestamp'        => ['1', 'HUIDIGETIJDSTEMPEL', 'CURRENTTIMESTAMP'],
    'currentversion'          => ['1', 'HUIDIGEVERSIE', 'CURRENTVERSION'],
    'currentweek'             => ['1', 'HUIDIGEWEEK', 'CURRENTWEEK'],
    'currentyear'             => ['1', 'HUIDIGJAAR', 'CURRENTYEAR'],
    'defaultsort'             => ['1', 'STANDAARDSORTERING:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:'],
    'defaultsort_noerror'     => ['0', 'geenfout', 'noerror'],
    'defaultsort_noreplace'   => ['0', 'nietvervangen', 'noreplace'],
    'directionmark'           => ['1', 'RICHTINGMARKERING', 'RICHTINGSMARKERING', 'DIRECTIONMARK', 'DIRMARK'],
    'displaytitle'            => ['1', 'WEERGEGEVENTITEL', 'TOONTITEL', 'DISPLAYTITLE'],
    'filepath'                => ['0', 'BESTANDSPAD:', 'FILEPATH:'],
    'forcetoc'                => ['0', '__INHOUD_DWINGEN__', '__FORCEERINHOUD__', '__FORCETOC__'],
    'formatdate'              => ['0', 'datumopmaak', 'formatdate', 'dateformat'],
    'formatnum'               => ['0', 'FORMATTEERNUM', 'NUMFORMATTEREN', 'FORMATNUM'],
    'fullpagename'            => ['1', 'VOLLEDIGEPAGINANAAM', 'FULLPAGENAME'],
    'fullpagenamee'           => ['1', 'VOLLEDIGEPAGINANAAME', 'FULLPAGENAMEE'],
    'fullurl'                 => ['0', 'VOLLEDIGEURL:', 'FULLURL:'],
    'fullurle'                => ['0', 'VOLLEDIGEURLE:', 'FULLURLE:'],
    'gender'                  => ['0', 'GESLACHT:', 'GENDER:'],
    'grammar'                 => ['0', 'GRAMMATICA:', 'GRAMMAR:'],
    'hiddencat'               => ['1', '__VERBORGENCAT__', '__HIDDENCAT__'],
    'img_baseline'            => ['1', 'grondlijn', 'baseline'],
    'img_border'              => ['1', 'rand', 'border'],
    'img_bottom'              => ['1', 'beneden', 'bottom'],
    'img_center'              => ['1', 'gecentreerd', 'center', 'centre'],
    'img_class'               => ['1', 'klasse=$1', 'class=$1'],
    'img_framed'              => ['1', 'omkaderd', 'frame', 'framed', 'enframed'],
    'img_frameless'           => ['1', 'kaderloos', 'frameless'],
    'img_lang'                => ['1', 'taal=$1', 'lang=$1'],
    'img_left'                => ['1', 'links', 'left'],
    'img_link'                => ['1', 'koppeling=$1', 'verwijzing=$1', 'link=$1'],
    'img_manualthumb'         => ['1', 'miniatuur=$1', 'thumbnail=$1', 'thumb=$1'],
    'img_middle'              => ['1', 'midden', 'middle'],
    'img_none'                => ['1', 'geen', 'none'],
    'img_page'                => ['1', 'pagina=$1', 'pagina_$1', 'page=$1', 'page $1'],
    'img_right'               => ['1', 'rechts', 'right'],
    'img_text_bottom'         => ['1', 'tekst-beneden', 'text-bottom'],
    'img_text_top'            => ['1', 'tekst-boven', 'text-top'],
    'img_thumbnail'           => ['1', 'miniatuur', 'thumb', 'thumbnail'],
    'img_top'                 => ['1', 'boven', 'top'],
    'img_upright'             => ['1', 'rechtop', 'rechtop=$1', 'rechtop$1', 'upright', 'upright=$1', 'upright $1'],
    'language'                => ['0', '#TAAL:', '#LANGUAGE:'],
    'lc'                      => ['0', 'KL:', 'LC:'],
    'lcfirst'                 => ['0', 'KLEERSTE:', 'LCFIRST:'],
    'localday'                => ['1', 'PLAATSELIJKEDAG', 'LOKALEDAG', 'LOCALDAY'],
    'localday2'               => ['1', 'PLAATSELIJKEDAG2', 'LOKALEDAG2', 'LOCALDAY2'],
    'localdayname'            => ['1', 'PLAATSELIJKEDAGNAAM', 'LOKALEDAGNAAM', 'LOCALDAYNAME'],
    'localdow'                => ['1', 'PLAATSELIJKEDVDW', 'LOKALEDVDW', 'LOCALDOW'],
    'localhour'               => ['1', 'PLAATSELIJKUUR', 'LOKAALUUR', 'LOCALHOUR'],
    'localmonth'              => ['1', 'PLAATSELIJKEMAAND', 'LOKALEMAAND', 'LOKALEMAAND2', 'LOCALMONTH', 'LOCALMONTH2'],
    'localmonth1'             => ['1', 'LOKALEMAAND1', 'LOCALMONTH1'],
    'localmonthabbrev'        => ['1', 'PLAATSELIJKEMAANDAFK', 'LOKALEMAANDAFK', 'LOCALMONTHABBREV'],
    'localmonthname'          => ['1', 'PLAATSELIJKEMAANDNAAM', 'LOKALEMAANDNAAM', 'LOCALMONTHNAME'],
    'localmonthnamegen'       => ['1', 'PLAATSELIJKEMAANDNAAMGEN', 'LOKALEMAANDNAAMGEN', 'LOCALMONTHNAMEGEN'],
    'localtime'               => ['1', 'PLAATSELIJKETIJD', 'LOKALETIJD', 'LOCALTIME'],
    'localtimestamp'          => ['1', 'PLAATSELIJKETIJDSTEMPEL', 'LOKALETIJDSTEMPEL', 'LOCALTIMESTAMP'],
    'localurl'                => ['0', 'LOKALEURL', 'LOCALURL:'],
    'localurle'               => ['0', 'LOKALEURLE', 'LOCALURLE:'],
    'localweek'               => ['1', 'PLAATSELIJKEWEEK', 'LOKALEWEEK', 'LOCALWEEK'],
    'localyear'               => ['1', 'PLAATSELIJKJAAR', 'LOKAALJAAR', 'LOCALYEAR'],
    'msg'                     => ['0', 'BERICHT:', 'MSG:'],
    'msgnw'                   => ['0', 'BERICHTNW', 'MSGNW:'],
    'namespace'               => ['1', 'NAAMRUIMTE', 'NAMESPACE'],
    'namespacee'              => ['1', 'NAAMRUIMTEE', 'NAMESPACEE'],
    'namespacenumber'         => ['1', 'NAAMRUIMTENUMMER', 'NAMESPACENUMBER'],
    'newsectionlink'          => ['1', '__NIEUWESECTIELINK__', '__NIEUWESECTIEKOPPELING__', '__NEWSECTIONLINK__'],
    'nocommafysuffix'         => ['0', 'GEENSCHEIDINGSTEKEN', 'NOSEP'],
    'nocontentconvert'        => ['0', '__GEENINHOUDCONVERSIE__', '__GEENIC__', '__NOCONTENTCONVERT__', '__NOCC__'],
    'noeditsection'           => ['0', '__NIETBEWERKBARESECTIE__', '__NOEDITSECTION__'],
    'nogallery'               => ['0', '__GEEN_GALERIJ__', '__NOGALLERY__'],
    'noindex'                 => ['1', '__GEENINDEX__', '__NOINDEX__'],
    'nonewsectionlink'        => ['1', '__GEENNIEUWKOPJEKOPPELING__', '__GEENNIEUWESECTIELINK__', '__GEENNIEUWKOPJEVERWIJZING__', '__NONEWSECTIONLINK__'],
    'notitleconvert'          => ['0', '__GEENPAGINANAAMCONVERSIE__', '__GEENTITELCONVERSIE__', '__GEENTC__', '__NOTITLECONVERT__', '__NOTC__'],
    'notoc'                   => ['0', '__GEENINHOUD__', '__NOTOC__'],
    'ns'                      => ['0', 'NR:', 'NS:'],
    'nse'                     => ['0', 'NRE:', 'NSE:'],
    'numberingroup'           => ['1', 'AANTALINGROEP', 'NUMBERINGROUP', 'NUMINGROUP'],
    'numberofactiveusers'     => ['1', 'AANTALACTIEVEGEBRUIKERS', 'ACTIEVEGEBRUIKERS', 'NUMBEROFACTIVEUSERS'],
    'numberofadmins'          => ['1', 'AANTALBEHEERDERS', 'AANTALADMINS', 'NUMBEROFADMINS'],
    'numberofarticles'        => ['1', 'AANTALARTIKELEN', 'NUMBEROFARTICLES'],
    'numberofedits'           => ['1', 'AANTALBEWERKINGEN', 'NUMBEROFEDITS'],
    'numberoffiles'           => ['1', 'AANTALBESTANDEN', 'NUMBEROFFILES'],
    'numberofpages'           => ['1', 'AANTALPAGINAS', 'AANTALPAGINA\'S', 'AANTALPAGINA’S', 'NUMBEROFPAGES'],
    'numberofusers'           => ['1', 'AANTALGEBRUIKERS', 'NUMBEROFUSERS'],
    'padleft'                 => ['0', 'LINKSOPVULLEN', 'PADLEFT'],
    'padright'                => ['0', 'RECHTSOPVULLEN', 'PADRIGHT'],
    'pageid'                  => ['0', 'PAGINAID', 'PAGEID'],
    'pagename'                => ['1', 'PAGINANAAM', 'PAGENAME'],
    'pagenamee'               => ['1', 'PAGINANAAME', 'PAGENAMEE'],
    'pagesincategory'         => ['1', 'PAGINASINCATEGORIE', 'PAGINASINCAT', 'PAGESINCATEGORY', 'PAGESINCAT'],
    'pagesincategory_all'     => ['0', 'alle', 'all'],
    'pagesincategory_files'   => ['0', 'bestanden', 'files'],
    'pagesincategory_pages'   => ['0', 'paginas', 'pages'],
    'pagesincategory_subcats' => ['0', 'ondercategorieen', 'subcats'],
    'pagesinnamespace'        => ['1', 'PAGINASINNAAMRUIMTE', 'PAGINA’SINNAAMRUIMTE', 'PAGINA\'SINNAAMRUIMTE', 'PAGESINNAMESPACE:', 'PAGESINNS:'],
    'pagesize'                => ['1', 'PAGINAGROOTTE', 'PAGESIZE'],
    'plural'                  => ['0', 'MEERVOUD:', 'PLURAL:'],
    'protectionlevel'         => ['1', 'BEVEILIGINGSNIVEAU', 'PROTECTIONLEVEL'],
    'raw'                     => ['0', 'RAUW:', 'RUW:', 'RAW:'],
    'rawsuffix'               => ['1', 'V', 'R'],
    'redirect'                => ['0', '#DOORVERWIJZING', '#REDIRECT'],
    'revisionday'             => ['1', 'VERSIEDAG', 'REVISIONDAY'],
    'revisionday2'            => ['1', 'VERSIEDAG2', 'REVISIONDAY2'],
    'revisionid'              => ['1', 'VERSIEID', 'REVISIONID'],
    'revisionmonth'           => ['1', 'VERSIEMAAND', 'REVISIONMONTH'],
    'revisionmonth1'          => ['1', 'VERSIEMAAND1', 'REVISIONMONTH1'],
    'revisionsize'            => ['1', 'VERSIEGROOTTE', 'REVISIONSIZE'],
    'revisiontimestamp'       => ['1', 'VERSIETIJD', 'REVISIONTIMESTAMP'],
    'revisionuser'            => ['1', 'VERSIEGEBRUIKER', 'REVISIONUSER'],
    'revisionyear'            => ['1', 'VERSIEJAAR', 'REVISIONYEAR'],
    'rootpagename'            => ['1', 'ROOTPAGINANAAM', 'ROOTPAGENAME'],
    'rootpagenamee'           => ['1', 'ROOTPAGINANAAME', 'ROOTPAGENAMEE'],
    'safesubst'               => ['0', 'VEILIGVERV:', 'SAFESUBST:'],
    'scriptpath'              => ['0', 'SCRIPTPAD', 'SCRIPTPATH'],
    'servername'              => ['0', 'SERVERNAAM', 'SERVERNAME'],
    'sitename'                => ['1', 'SITENAAM', 'SITENAME'],
    'special'                 => ['0', 'speciaal', 'special'],
    'speciale'                => ['0', 'speciaale', 'speciale'],
    'staticredirect'          => ['1', '__STATISCHEDOORVERWIJZING__', '__STATISCHEREDIRECT__', '__STATICREDIRECT__'],
    'stylepath'               => ['0', 'STIJLPAD', 'STYLEPATH'],
    'subjectpagename'         => ['1', 'ONDERWERPPAGINANAAM', 'ARTIKELPAGINANAAM', 'SUBJECTPAGENAME', 'ARTICLEPAGENAME'],
    'subjectpagenamee'        => ['1', 'ONDERWERPPAGINANAAME', 'ARTIKELPAGINANAAME', 'SUBJECTPAGENAMEE', 'ARTICLEPAGENAMEE'],
    'subjectspace'            => ['1', 'ONDERWERPRUIMTE', 'ARTIKELRUIMTE', 'SUBJECTSPACE', 'ARTICLESPACE'],
    'subjectspacee'           => ['1', 'ONDERWERPRUIMTEE', 'ARTIKELRUIMTEE', 'SUBJECTSPACEE', 'ARTICLESPACEE'],
    'subpagename'             => ['1', 'DEELPAGINANAAM', 'SUBPAGENAME'],
    'subpagenamee'            => ['1', 'DEELPAGINANAAME', 'SUBPAGENAMEE'],
    'subst'                   => ['0', 'VERV:', 'SUBST:'],
    'tag'                     => ['0', 'label', 'tag'],
    'talkpagename'            => ['1', 'OVERLEGPAGINANAAM', 'TALKPAGENAME'],
    'talkpagenamee'           => ['1', 'OVERLEGPAGINANAAME', 'TALKPAGENAMEE'],
    'talkspace'               => ['1', 'OVERLEGRUIMTE', 'TALKSPACE'],
    'talkspacee'              => ['1', 'OVERLEGRUIMTEE', 'TALKSPACEE'],
    'toc'                     => ['0', '__INHOUD__', '__TOC__'],
    'uc'                      => ['0', 'HL:', 'UC:'],
    'ucfirst'                 => ['0', 'GLEERSTE:', 'HLEERSTE:', 'UCFIRST:'],
    'urlencode'               => ['0', 'URLCODEREN', 'CODEERURL', 'URLENCODE:'],
    'url_path'                => ['0', 'PAD', 'PATH'],
    'url_query'               => ['0', 'ZOEKOPDRACHT', 'QUERY'],
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Activeusers'             => ['ActieveGebruikers'],
    'Allmessages'             => ['AlleBerichten', 'Systeemberichten'],
    'AllMyUploads'            => ['AlMijnUploads'],
    'Allpages'                => ['AllePaginas', 'AllePagina’s', 'AllePagina\'s'],
    'Ancientpages'            => ['OudstePaginas', 'OudstePagina’s', 'OudstePagina\'s'],
    'ApiHelp'                 => ['ApiHulp'],
    'Badtitle'                => ['OnjuistePaginanaam'],
    'Blankpage'               => ['LegePagina'],
    'Block'                   => ['Blokkeren', 'IPblokkeren', 'BlokkeerIP', 'BlokkeerIp'],
    'BlockList'               => ['Blokkeerlijst', 'IP-blokkeerlijst', 'IPblokkeerlijst', 'IpBlokkeerlijst'],
    'Booksources'             => ['Boekbronnen', 'Boekinformatie'],
    'BrokenRedirects'         => ['GebrokenDoorverwijzingen'],
    'Categories'              => ['Categorieën'],
    'ChangeEmail'             => ['E-mailWijzigen'],
    'ChangePassword'          => ['WachtwoordWijzigen', 'WachtwoordHerinitialiseren'],
    'ComparePages'            => ['PaginasVergelijken', 'Pagina\'sVergelijken'],
    'Confirmemail'            => ['Emailbevestigen', 'E-mailbevestigen'],
    'Contributions'           => ['Bijdragen'],
    'CreateAccount'           => ['GebruikerAanmaken'],
    'Deadendpages'            => ['VerwijslozePaginas', 'VerwijslozePagina’s', 'VerwijslozePagina\'s'],
    'DeletedContributions'    => ['VerwijderdeBijdragen'],
    'DoubleRedirects'         => ['DubbeleDoorverwijzingen'],
    'EditWatchlist'           => ['VolglijstBewerken'],
    'Emailuser'               => ['GebruikerE-mailen', 'E-mailGebruiker'],
    'ExpandTemplates'         => ['SjablonenSubstitueren'],
    'Export'                  => ['Exporteren'],
    'Fewestrevisions'         => ['MinsteVersies', 'MinsteHerzieningen', 'MinsteRevisies'],
    'FileDuplicateSearch'     => ['BestandsduplicatenZoeken'],
    'Filepath'                => ['Bestandspad'],
    'Import'                  => ['Importeren'],
    'Invalidateemail'         => ['EmailAnnuleren'],
    'LinkSearch'              => ['VerwijzingenZoeken', 'LinksZoeken'],
    'Listadmins'              => ['Beheerderlijst', 'Administratorlijst', 'Adminlijst', 'Beheerderslijst'],
    'Listbots'                => ['Botlijst', 'Lijstbots'],
    'ListDuplicatedFiles'     => ['DuplicaatbestandenWeergeven'],
    'Listfiles'               => ['Bestandenlijst', 'Afbeeldingenlijst'],
    'Listgrouprights'         => ['GroepsrechtenWeergeven'],
    'Listredirects'           => ['Doorverwijzinglijst', 'Redirectlijst'],
    'Listusers'               => ['Gebruikerslijst', 'Gebruikerlijst'],
    'Lockdb'                  => ['DBblokkeren', 'DbBlokkeren', 'BlokkeerDB'],
    'Log'                     => ['Logboeken', 'Logboek'],
    'Lonelypages'             => ['Weespaginas', 'Weespagina\'s'],
    'Longpages'               => ['LangePaginas', 'LangePagina’s', 'LangePagina\'s'],
    'MediaStatistics'         => ['Mediastatistieken'],
    'MergeHistory'            => ['GeschiedenisSamenvoegen'],
    'MIMEsearch'              => ['MIMEzoeken', 'MIME-zoeken'],
    'Mostcategories'          => ['MeesteCategorieën'],
    'Mostimages'              => ['MeesteVerwezenBestanden', 'MeesteBestanden', 'MeesteAfbeeldingen'],
    'Mostinterwikis'          => ['MeesteInterwikiverwijzingen'],
    'Mostlinked'              => ['MeestVerwezenPaginas', 'MeestVerwezenPagina\'s', 'MeestVerwezen'],
    'Mostlinkedcategories'    => ['MeestVerwezenCategorieën'],
    'Mostlinkedtemplates'     => ['MeestVerwezenSjablonen'],
    'Mostrevisions'           => ['MeesteVersies', 'MeesteHerzieningen', 'MeesteRevisies'],
    'Movepage'                => ['PaginaHernoemen', 'PaginaVerplaatsen', 'TitelWijzigen', 'VerplaatsPagina'],
    'Mycontributions'         => ['MijnBijdragen'],
    'MyLanguage'              => ['MijnTaal'],
    'Mypage'                  => ['MijnPagina'],
    'Mytalk'                  => ['MijnOverleg'],
    'Myuploads'               => ['MijnUploads'],
    'Newimages'               => ['NieuweBestanden', 'NieuweAfbeeldingen'],
    'Newpages'                => ['NieuwePaginas', 'NieuwePagina’s', 'NieuwePagina\'s'],
    'PageLanguage'            => ['Paginataal'],
    'PagesWithProp'           => ['PaginasMetEigenschap', 'Pagina\'sMetEigenschap'],
    'PasswordReset'           => ['WachtwoordOpnieuwInstellen'],
    'PermanentLink'           => ['PermanenteVerwijzing'],
    'Preferences'             => ['Voorkeuren'],
    'Prefixindex'             => ['Voorvoegselindex'],
    'Protectedpages'          => ['BeveiligdePaginas', 'BeveiligdePagina\'s', 'BeschermdePaginas', 'BeschermdePagina’s', 'BeschermdePagina\'s'],
    'Protectedtitles'         => ['BeveiligdeTitels', 'BeschermdeTitels'],
    'RandomInCategory'        => ['WillekeurigeUitCategorie'],
    'Randompage'              => ['Willekeurig', 'WillekeurigePagina'],
    'Randomredirect'          => ['WillekeurigeDoorverwijzing'],
    'Randomrootpage'          => ['WillekeurigeHoofdpagina'],
    'Recentchanges'           => ['RecenteWijzigingen'],
    'Recentchangeslinked'     => ['RecenteWijzigingenGelinkt', 'VerwanteWijzigingen'],
    'Redirect'                => ['Doorverwijzen'],
    'ResetTokens'             => ['TokensOpnieuwInstellen'],
    'Revisiondelete'          => ['VersieVerwijderen', 'HerzieningVerwijderen', 'RevisieVerwijderen'],
    'RunJobs'                 => ['TakenUitvoeren'],
    'Search'                  => ['Zoeken'],
    'Shortpages'              => ['KortePaginas', 'KortePagina’s', 'KortePagina\'s'],
    'Specialpages'            => ['SpecialePaginas', 'SpecialePagina’s', 'SpecialePagina\'s'],
    'Statistics'              => ['Statistieken'],
    'Tags'                    => ['Labels'],
    'TrackingCategories'      => ['Trackingcategorieen'],
    'Unblock'                 => ['Deblokkeren'],
    'Uncategorizedcategories' => ['NietGecategoriseerdeCategorieën', 'Niet-GecategoriseerdeCategorieën'],
    'Uncategorizedimages'     => ['NietGecategoriseerdeBestanden', 'NietGecategoriseerdeAfbeeldingen', 'Niet-GecategoriseerdeAfbeeldingen'],
    'Uncategorizedpages'      => ['NietGecategoriseerdePaginas', 'Niet-GecategoriseerdePagina’s', 'Niet-GecategoriseerdePagina\'s'],
    'Uncategorizedtemplates'  => ['NietGecategoriseerdeSjablonen'],
    'Undelete'                => ['Terugplaatsen', 'Herstellen', 'VerwijderenOngedaanMaken'],
    'Unlockdb'                => ['DBvrijgeven', 'DbVrijgeven', 'GeefDbVrij'],
    'Unusedcategories'        => ['OngebruikteCategorieën'],
    'Unusedimages'            => ['OngebruikteBestanden', 'OngebruikteAfbeeldingen'],
    'Unusedtemplates'         => ['OngebruikteSjablonen'],
    'Unwatchedpages'          => ['NietGevolgdePaginas', 'Niet-GevolgdePagina’s', 'Niet-GevolgdePagina\'s'],
    'Upload'                  => ['Uploaden'],
    'UploadStash'             => ['TijdelijkeUpload'],
    'Userlogin'               => ['Aanmelden', 'Inloggen'],
    'Userlogout'              => ['Afmelden', 'Uitloggen'],
    'Userrights'              => ['Gebruikersrechten', 'Gebruikerrechten'],
    'Version'                 => ['Softwareversie', 'Versie'],
    'Wantedcategories'        => ['GevraagdeCategorieën'],
    'Wantedfiles'             => ['GevraagdeBestanden'],
    'Wantedpages'             => ['GevraagdePaginas', 'GevraagdePagina\'s', 'GevraagdePagina’s'],
    'Wantedtemplates'         => ['GevraagdeSjablonen'],
    'Watchlist'               => ['Volglijst'],
    'Whatlinkshere'           => ['VerwijzingenNaarHier', 'Verwijzingen', 'LinksNaarHier'],
    'Withoutinterwiki'        => ['ZonderInterwiki'],
];

$linkTrail = '/^([a-zäöüïëéèà]+)(.*)$/sDu';
