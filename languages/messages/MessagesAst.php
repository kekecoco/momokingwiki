<?php
/** Asturian (asturianu)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

$fallback = 'es';

$namespaceNames = [
    NS_MEDIA          => 'Medios',
    NS_SPECIAL        => 'Especial',
    NS_TALK           => 'Alderique',
    NS_USER           => 'Usuariu',
    NS_USER_TALK      => 'Usuariu_alderique',
    NS_PROJECT_TALK   => '$1_alderique',
    NS_FILE           => 'Ficheru',
    NS_FILE_TALK      => 'Ficheru_alderique',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'MediaWiki_alderique',
    NS_TEMPLATE       => 'Plantía',
    NS_TEMPLATE_TALK  => 'Plantía_alderique',
    NS_HELP           => 'Ayuda',
    NS_HELP_TALK      => 'Ayuda_alderique',
    NS_CATEGORY       => 'Categoría',
    NS_CATEGORY_TALK  => 'Categoría_alderique',
];

$namespaceAliases = [
    'Imaxe'               => NS_FILE,
    'Imaxe_alderique'     => NS_FILE_TALK,
    'Discusión'           => NS_TALK,
    'Usuariu_discusión'   => NS_USER_TALK,
    '$1_discusión'        => NS_PROJECT_TALK,
    'Imaxen'              => NS_FILE,
    'Imaxen_discusión'    => NS_FILE_TALK,
    'Archivu'             => NS_FILE,
    'Archivu_alderique'   => NS_FILE_TALK,
    'MediaWiki_discusión' => NS_MEDIAWIKI_TALK,
    'Plantilla'           => NS_TEMPLATE,
    'Plantilla_discusión' => NS_TEMPLATE_TALK,
    'Ayuda_discusión'     => NS_HELP_TALK,
    'Aida'                => NS_HELP,
    'Aida_alderique'      => NS_HELP_TALK,
    'Categoría_discusión' => NS_CATEGORY_TALK,
];

$namespaceGenderAliases = [
    NS_USER      => ['male' => 'Usuariu', 'female' => 'Usuaria'],
    NS_USER_TALK => ['male' => 'Usuariu_alderique', 'female' => 'Usuaria_alderique'],
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Block'         => ['Bloquiar', 'BloquiarIP', 'BloquiarUsuariu'],
    'Log'           => ['Rexistru', 'Rexistros'],
    'Recentchanges' => ['CambeosRecientes'],
    'Search'        => ['Gueta'],
    'Statistics'    => ['Estadístiques'],
];
