<?php
/** Mirandese (Mirandés)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 *
 * @author Alchimista
 * @author Athena
 * @author Cecílio
 * @author MCruz
 * @author Malafaya
 * @author Romaine
 * @author Urhixidur
 */

$fallback = 'pt';

$namespaceNames = [
    NS_MEDIA          => 'Multimédia',
    NS_SPECIAL        => 'Special',
    NS_TALK           => 'Cumbersa',
    NS_USER           => 'Outelizador(a)',
    NS_USER_TALK      => 'Cumbersa_outelizador(a)',
    NS_PROJECT_TALK   => 'Cumbersa_$1',
    NS_FILE           => 'Fexeiro',
    NS_FILE_TALK      => 'Cumbersa_fexeiro',
    NS_MEDIAWIKI      => 'Biqui',
    NS_MEDIAWIKI_TALK => 'Cumbersa_Biqui',
    NS_TEMPLATE       => 'Modelo',
    NS_TEMPLATE_TALK  => 'Cumbersa_modelo',
    NS_HELP           => 'Ajuda',
    NS_HELP_TALK      => 'Cumbersa_ajuda',
    NS_CATEGORY       => 'Catadorie',
    NS_CATEGORY_TALK  => 'Cumbersa_catadorie',
];

$namespaceAliases = [
    'Especial'               => NS_SPECIAL,
    'Discussão'              => NS_TALK,
    'Usuário'                => NS_USER,
    'Usuário_Discussão'      => NS_USER_TALK,
    '$1_Discussão'           => NS_PROJECT_TALK,
    'Ficheiro'               => NS_FILE,
    'Ficheiro_Discussão'     => NS_FILE_TALK,
    'Imagem'                 => NS_FILE,
    'Imagem_Discussão'       => NS_FILE_TALK,
    "MediaWiki"              => NS_MEDIAWIKI,
    'MediaWiki_Discussão'    => NS_MEDIAWIKI_TALK,
    'Predefinição'           => NS_TEMPLATE,
    'Predefinição_Discussão' => NS_TEMPLATE_TALK,
    'Ajuda_Discussão'        => NS_HELP_TALK,
    'Categoria'              => NS_CATEGORY,
    'Categoria_Discussão'    => NS_CATEGORY_TALK,
    "Media"                  => NS_MEDIA,
    "Utilizador"             => NS_USER,
    "Utilizadora"            => NS_USER,
    "Cumbersa_Modelo"        => NS_TEMPLATE_TALK,
    "$1_cumbersa"            => NS_PROJECT_TALK,
];

$namespaceGenderAliases = [
    NS_USER      => ['male' => 'Outelizador', 'female' => 'Outelizadora'],
    NS_USER_TALK => ['male' => 'Cumbersa_outelizador', 'female' => 'Cumbersa_outelizadora'],
]; // T180052

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'CreateAccount'           => ['Criar_Cuonta'],
    'Lonelypages'             => ['Páiginas_Uorfanas'],
    'Uncategorizedcategories' => ['Catadories_sien_catadories'],
    'Uncategorizedimages'     => ['Eimaiges_sien_catadories'],
    'Userlogin'               => ['Antrar'],
    'Userlogout'              => ['Salir'],
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'filepath'       => ['0', 'CAMINOFEXEIRO:', 'CAMINHODOARQUIVO', 'FILEPATH:'],
    'img_center'     => ['1', 'centro', 'center', 'centre'],
    'img_left'       => ['1', 'squierda', 'esquerda', 'left'],
    'img_middle'     => ['1', 'meio', 'middle'],
    'img_none'       => ['1', 'nanhun', 'nenhum', 'none'],
    'img_right'      => ['1', 'dreita', 'direita', 'right'],
    'language'       => ['0', '#LHENGUA:', '#IDIOMA:', '#LANGUAGE:'],
    'pagesize'       => ['1', 'TAMANHOFEXEIRO', 'TAMANHODAPAGINA', 'TAMANHODAPÁGINA', 'PAGESIZE'],
    'redirect'       => ['0', '#ANCAMINAR', '#REDIRECIONAMENTO', '#REDIRECT'],
    'staticredirect' => ['1', '_ANCAMINARSTATICO_', '__REDIRECIONAMENTOESTATICO__', '__REDIRECIONAMENTOESTÁTICO__', '__STATICREDIRECT__'],
    'tag'            => ['0', 'eitiqueta', 'tag'],
];
