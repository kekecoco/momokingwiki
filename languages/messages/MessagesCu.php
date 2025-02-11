<?php
/** Church Slavic (словѣньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Allpages'      => ['Вьсѩ_страницѧ'],
    'Categories'    => ['Катигорїѩ'],
    'Contributions' => ['Добродѣꙗниꙗ'],
    'Preferences'   => ['Строи'],
    'Recentchanges' => ['Послѣдьнѩ_мѣнꙑ'],
    'Search'        => ['Исканиѥ'],
    'Statistics'    => ['Статїстїка'],
    'Upload'        => ['Положєниѥ_дѣла'],
];

$namespaceNames = [
    NS_MEDIA          => 'Срѣдьства',
    NS_SPECIAL        => 'Нарочьна',
    NS_TALK           => 'Бєсѣда',
    NS_USER           => 'Польꙃєватєл҄ь',
    NS_USER_TALK      => 'Польꙃєватєлꙗ_бєсѣда',
    NS_PROJECT_TALK   => '{{GRAMMAR:genitive|$1}}_бєсѣда',
    NS_FILE           => 'Дѣло',
    NS_FILE_TALK      => 'Дѣла_бєсѣда',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'MediaWiki_бєсѣда',
    NS_TEMPLATE       => 'Обраꙁьць',
    NS_TEMPLATE_TALK  => 'Обраꙁьца_бєсѣда',
    NS_HELP           => 'Помощь',
    NS_HELP_TALK      => 'Помощи_бєсѣда',
    NS_CATEGORY       => 'Катигорїꙗ',
    NS_CATEGORY_TALK  => 'Катигорїѩ_бєсѣда',
];

$namespaceAliases = [
    'Срѣдьства'                      => NS_MEDIA,
    'Нарочьна'                       => NS_SPECIAL,
    'Бесѣда'                         => NS_TALK,
    'Польѕевател҄ь'                  => NS_USER,
    'Польѕевател_бесѣда'            => NS_USER_TALK,
    '{{grammar:genitive|$1}}_бесѣда' => NS_PROJECT_TALK,
    'Ви́дъ'                          => NS_FILE,
    'Видъ'                           => NS_FILE,
    'Ви́да_бєсѣ́да'                  => NS_FILE_TALK,
    'Вида_бесѣда'                    => NS_FILE_TALK,
    'MediaWiki_бесѣда'               => NS_MEDIAWIKI_TALK,
    'Образьць'                       => NS_TEMPLATE,
    'Образьца_бесѣда'                => NS_TEMPLATE_TALK,
    'Помощь'                         => NS_HELP,
    'Помощи_бесѣда'                  => NS_HELP_TALK,
    'Катигорї'                      => NS_CATEGORY,
    'Катигорїѩ_бесѣда'               => NS_CATEGORY_TALK,
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'language' => ['0', '#ѨꙀꙐКЪ:', '#LANGUAGE:'],
    'redirect' => ['0', '#ПРѢНАПРАВЛЄНИѤ', '#REDIRECT'],
];

$separatorTransformTable = [
    ',' => ".",
    '.' => ','
];

$linkPrefixExtension = true;

$defaultDateFormat = 'mdy';

$dateFormats = [
    'mdy time' => 'H:i',
    'mdy date' => 'xg j числа, Y',
    'mdy both' => 'H:i, xg j числа, Y',

    'dmy time' => 'H:i',
    'dmy date' => 'j F Y',
    'dmy both' => 'H:i, j F Y',

    'ymd time' => 'H:i',
    'ymd date' => 'Y F j',
    'ymd both' => 'H:i, Y F j',

    'ISO 8601 time' => 'xnH:xni:xns',
    'ISO 8601 date' => 'xnY-xnm-xnd',
    'ISO 8601 both' => 'xnY-xnm-xnd"T"xnH:xni:xns',
];

$linkTrail = '/^([a-zабвгдеєжѕзїіıићклмнопсстѹфхѡѿцчшщъыьѣюѥѧѩѫѭѯѱѳѷѵґѓђёјйљњќуўџэ҄я“»]+)(.*)$/sDu';
$linkPrefixCharset = '„«';
