<?php
/** Lezghian (лезги)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 *
 * @author Amikeco
 * @author Andrijko Z.
 * @author Aslan4ik
 * @author Cekli829
 * @author Lezgia
 * @author MF-Warburg
 * @author Migraghvi
 * @author Namik
 * @author Nemo bis
 * @author Ole Yves
 * @author Reedy
 * @author Soul Train
 * @author Умар
 */

$fallback = 'ru, az';

$namespaceNames = [
    NS_MEDIA          => 'Медиа',
    NS_TALK           => 'Веревирд_авун',
    NS_USER           => 'Уртах',
    NS_USER_TALK      => 'Уртахдин_веревирд_авун',
    NS_PROJECT_TALK   => '$1_веревирд_авун',
    NS_FILE           => 'Файл',
    NS_FILE_TALK      => 'Файл_веревирд_авун',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'MediaWiki_веревирд_авун',
    NS_TEMPLATE       => 'Шаблон',
    NS_TEMPLATE_TALK  => 'Шаблон_веревирд_авун',
    NS_CATEGORY       => 'Категория',
    NS_CATEGORY_TALK  => 'Категория_веревирд_авун',
];

$namespaceAliases = [
    # Russian namespaces
    'Обсуждение'                         => NS_TALK,
    'Участник'                           => NS_USER,
    'Обсуждение_участника'               => NS_USER_TALK,
    'Обсуждение_{{GRAMMAR:genitive|$1}}' => NS_PROJECT_TALK,
    'Обсуждение_файла'                   => NS_FILE_TALK,
    'Обсуждение_MediaWiki'               => NS_MEDIAWIKI_TALK,
    'Обсуждение_шаблона'                 => NS_TEMPLATE_TALK,
    'Справка'                            => NS_HELP,
    'Обсуждение_справки'                 => NS_HELP_TALK,
    'Категория'                          => NS_CATEGORY,
    'Обсуждение_категории'               => NS_CATEGORY_TALK,
];

// Remove Russian gender aliases
$namespaceGenderAliases = [];

$linkTrail = '/^([a-zабвгдеёжзийклмнопрстуфхцчшщъыьэюяӀ]+)(.*)$/sDu';
