<?php
/** Deitsch (Deitsch)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 *
 * @author Kaganer
 * @author Krinkle
 * @author Shirayuki
 * @author Xqt
 * @author לערי ריינהארט
 */

$fallback = 'de';

$namespaceNames = [
    NS_TALK           => 'Dischbedutt',
    NS_USER           => 'Yuuser',
    NS_USER_TALK      => 'Yuuser_Dischbedutt',
    NS_PROJECT_TALK   => '$1_Dischbedutt',
    NS_FILE           => 'Feil',
    NS_FILE_TALK      => 'Feil_Dischbedutt',
    NS_MEDIAWIKI_TALK => 'MediaWiki_Dischbedutt',
    NS_TEMPLATE       => 'Moddel',
    NS_TEMPLATE_TALK  => 'Moddel_Dischbedutt',
    NS_HELP           => 'Hilf',
    NS_HELP_TALK      => 'Hilf_Dischbedutt',
    NS_CATEGORY       => 'Abdeeling',
    NS_CATEGORY_TALK  => 'Abdeeling_Dischbedutt',
];

$namespaceAliases = [
    # German namespaces
    'Medium'               => NS_MEDIA,
    'Spezial'              => NS_SPECIAL,
    'Diskussion'           => NS_TALK,
    'Benutzer'             => NS_USER,
    'Benutzer_Diskussion'  => NS_USER_TALK,
    '$1_Diskussion'        => NS_PROJECT_TALK,
    'Datei'                => NS_FILE,
    'Datei_Diskussion'     => NS_FILE_TALK,
    'MediaWiki_Diskussion' => NS_MEDIAWIKI_TALK,
    'Vorlage'              => NS_TEMPLATE,
    'Vorlage_Diskussion'   => NS_TEMPLATE_TALK,
    'Hilfe'                => NS_HELP,
    'Hilfe_Diskussion'     => NS_HELP_TALK,
    'Kategorie'            => NS_CATEGORY,
    'Kategorie_Diskussion' => NS_CATEGORY_TALK,
];

// Remove German aliases
$namespaceGenderAliases = [];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Listadmins' => ['Verwalter', 'Administratoren'],
    'Listbots'   => ['Waddefresser', 'Bots'],
    'Search'     => ['Uffgucke', 'Suche'],
];
