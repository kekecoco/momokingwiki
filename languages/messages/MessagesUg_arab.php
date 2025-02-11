<?php
/** Uyghur (Arabic script) (ئۇيغۇرچە)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 *
 * @author Alfredie
 * @author Arlin
 * @author Calak
 * @author Kaganer
 * @author Reedy
 * @author Sahran
 * @author Tel'et
 * @author بىلگە
 */

$rtl = true;

$namespaceNames = [
    NS_MEDIA          => 'ۋاسىتە',
    NS_SPECIAL        => 'ئالاھىدە',
    NS_TALK           => 'مۇنازىرە',
    NS_USER           => 'ئىشلەتكۈچى',
    NS_USER_TALK      => 'ئىشلەتكۈچى_مۇنازىرىسى',
    NS_PROJECT_TALK   => '$1مۇنازىرىسى',
    NS_FILE           => 'ھۆججەت',
    NS_FILE_TALK      => 'ھۆججەت_مۇنازىرىسى',
    NS_MEDIAWIKI_TALK => 'MediaWiki_مۇنازىرىسى',
    NS_TEMPLATE       => 'قېلىپ',
    NS_TEMPLATE_TALK  => 'قېلىپ_مۇنازىرىسى',
    NS_HELP           => 'ياردەم',
    NS_HELP_TALK      => 'ياردەم_مۇنازىرىسى',
    NS_CATEGORY       => 'تۈر',
    NS_CATEGORY_TALK  => 'تۈر_مۇنازىرىسى',
];

$namespaceAliases = [
    'مۇنازىرىسى$1' => NS_PROJECT_TALK,
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Allmessages'  => ['بارلىق_خەۋەرلەر'],
    'Allpages'     => ['بارلىق_بەتلەر'],
    'Ancientpages' => ['كونا_بەتلەر'],
];
