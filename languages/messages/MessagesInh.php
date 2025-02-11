<?php
/** Ingush (ГӀалгӀай)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 *
 * @author Adam-Yourist
 * @author Ӏабдуррашид
 */

$fallback = 'ru';

$namespaceNames = [
    NS_MEDIA          => 'Медиа',
    NS_SPECIAL        => 'Гӏулакха',
    NS_TALK           => 'Ювцар',
    NS_USER           => 'Доакъашхо',
    NS_USER_TALK      => 'Доакъашхочун_дувцар',
    NS_PROJECT_TALK   => '$1_ювцар',
    NS_FILE           => 'Файл',
    NS_FILE_TALK      => 'Файл_ювцар',
    NS_MEDIAWIKI      => 'MediaWiki',
    NS_MEDIAWIKI_TALK => 'MediaWiki_ювцар',
    NS_TEMPLATE       => 'Ло',
    NS_TEMPLATE_TALK  => 'Ло_бувцар',
    NS_HELP           => 'Новкъостал',
    NS_HELP_TALK      => 'Новкъостал_дувцар',
    NS_CATEGORY       => 'ОагӀат',
    NS_CATEGORY_TALK  => 'ОагӀат_ювцар',
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'redirect' => [0, '#ластар', '#REDIRECT'],
];

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Activeusers'             => ['Хьинаре_доакъашхой', 'Хьинаре_бола_доакъашхой'],
    'Allmessages'             => ['Система_хоамаш', 'Системацара_хоамаш'],
    'AllMyUploads'            => ['Са_еррига_файлаш', 'Са_мел_йола_файлаш'],
    'Allpages'                => ['Еррига_оагӀонаш'],
    'Badtitle'                => ['Мегаргйоаца_цӀи', 'ЦӀи_пайдан_яц', 'ЦӀи_харц_я'],
    'Blankpage'               => ['Яьсса_оагӀув'],
    'Block'                   => ['Блок_тоха', 'Блок_оттае'],
    'BlockList'               => ['Блок_тохар', 'Блок_техараш', 'Блок_техарий_мугӀам', 'Блок_тохарий_мугӀам', 'Блокировкаш'],
    'Booksources'             => ['Дешаргий_хьасташ', 'Кинижкий_хьасташ'],
    'BrokenRedirects'         => ['Хоададаь_ластараш', 'Хаьда_ластараш', 'Хаьда_ластар-оагӀонаш'],
    'Categories'              => ['ОагӀаташ'],
    'ChangeEmail'             => ['ДӀахувца_e-mail', 'E-mail_дӀахувца', 'ДӀахувца_пошт', 'Пошт_дӀахувца'],
    'ChangePassword'          => ['Пароль_дӀахувца'],
    'ComparePages'            => ['ОагӀонаш_йистар'],
    'Confirmemail'            => ['Бакъъе_e-mail', 'E-mail_бакъъе', 'Бакъъе_пошт', 'Пошт_бакъъе'],
    'Contributions'           => ['Къахьегам'],
    'CreateAccount'           => ['Аккаунт_хьакхолла', 'Дагара_йоазув_хьакхолла', 'Регистраци_е', 'ДӀахоттале'],
    'Deadendpages'            => ['Кхычарна_тӀатовжаш_йоаца_оагӀонаш', 'Тупик_йола_оагӀонаш'],
    'DeletedContributions'    => ['ДӀабаьккха_къахьегам', 'ДӀабаьккха_хинна_къахьегам'],
    'Diff'                    => ['Хувцамаш'],
    'DoubleRedirects'         => ['Шолха_ластараш'],
    'EditWatchlist'           => ['Зема_мугӀам_тоабе', 'Зем-мугӀам_тоабе'],
    'Emailuser'               => ['Каьхат_дахийта', 'Доакъашхочунга_дохийта_каьхат'],
    'ExpandTemplates'         => ['Лераш_хьадоаржадар', 'Лераш_Ӏодастар'],
    'Export'                  => ['Экспорт', 'Хьаарадаккхар'],
    'Fewestrevisions'         => ['Наггахьа_тоаераш', 'Наггахьа_мара_цатоаераш'],
    'FileDuplicateSearch'     => ['Файлий_дубликаташ_лахар'],
    'Filepath'                => ['Файлага_бода_никъ'],
    'Import'                  => ['Импорт'],
    'Invalidateemail'         => ['Адрес_бакъдар_юхадаккха', 'ЦӀай_бакъдар_юхадаккха'],
    'JavaScriptTest'          => ['JavaScript_тестировани', 'JavaScript_тестировани_яр'],
    'LinkSearch'              => ['ТӀатовжамаш_лахар'],
    'Listadmins'              => ['Администраторий_мугӀам'],
    'Listbots'                => ['Ботий_мугӀам'],
    'ListDuplicatedFiles'     => ['Дубликат_йолча_файлий_мугӀам', 'Файл-дубликатий_мугӀам'],
    'Listfiles'               => ['Файлий_мугӀам', 'Суртий_мугӀам'],
    'Listgrouprights'         => ['Доакъашхой_тоабай_бокъонаш', 'Тоабай_бокъоний_мугӀам'],
    'Listredirects'           => ['Ластарий_мугӀам'],
    'Listusers'               => ['Доакъашхой_мугӀам'],
    'Lockdb'                  => ['Дарий_базанна_блок_тоха'],
    'Log'                     => ['Тептараш', 'Тептар'],
    'Lonelypages'             => ['Цхьаннахьара_а_тӀатовжам_боаца_оагӀонаш', 'Къоастаяь_йола_оагӀонаш'],
    'Longpages'               => ['ЙӀаьха_оагӀонаш'],
    'MergeHistory'            => ['Тархьараш_вӀашагӀтохар', 'Тархьараш_вӀашагӀхоттар'],
    'MIMEsearch'              => ['MIME_гӀолла_лахар', 'Лахар_MIME_гӀолла', 'Лахар_MIME-ца'],
    'Mostcategories'          => ['Эггара_дукхагӀа_оагӀаташ_яраш', 'Дуккхача_оагӀаташта_юкъеяьха_йола_оагӀонаш'],
    'Mostimages'              => ['Эггара_дукхагӀа_лелаю_файлаш'],
    'Mostinterwikis'          => ['Эггара_дукхагӀа_интервики-тӀатовжамаш_дола_оагӀонаш', 'Эггара_дукхагӀа_интервики-тӀатовжамаш'],
    'Mostlinked'              => ['Эггара_дукхагӀа_кхычахьара_тӀатовжамаш_дола_оагӀонаш', 'Эггара_дукхагӀа_лелаю_оагӀонаш'],
    'Mostlinkedcategories'    => ['Эггара_дукхагӀа_лелаю_оагӀаташ', 'Эггара_дукхагӀа_кхычахьара_тӀатовжамаш_дола_оагӀаташ'],
    'Mostlinkedtemplates'     => ['Эггара_дукхагӀа_леладу_лераш'],
    'Mostrevisions'           => ['Эггара_дукхагӀа_эршаш_яраш', 'Эггара_дукхагӀа_тоаяь_оагӀонаш'],
    'Movepage'                => ['ОагӀон_цӀи_хувца', 'ЦӀи_хувцар', 'ЦӀи_хувца'],
    'Mycontributions'         => ['Са_къахьегам'],
    'MyLanguage'              => ['Са_мотт'],
    'Mypage'                  => ['Са_оагӀув'],
    'Mytalk'                  => ['Са_къамаьл'],
    'Myuploads'               => ['Аз_чудаьккхар', 'Аз_чудаьхараш'],
    'Newimages'               => ['Керда_файлаш'],
    'Newpages'                => ['Керда_оагӀонаш'],
    'PasswordReset'           => ['Пароль_тӀеракхоссар'],
    'PermanentLink'           => ['Даим_бола_тӀатовжам'],
    'Preferences'             => ['Оттамаш'],
    'Prefixindex'             => ['ОагӀонаш_шоай_цӀерий_хьалхарча_алапах_хьокхар'],
    'Protectedpages'          => ['Лораеш_йола_оагӀонаш'],
    'Protectedtitles'         => ['Лораеш_йола_цӀераш'],
    'Randompage'              => ['Цаховш_нийсъенна_оагӀув', 'Цаховш_нийсъенна'],
    'Randomredirect'          => ['Цаховш_нийсденна_ластар'],
    'Recentchanges'           => ['Керда_хувцамаш'],
    'Recentchangeslinked'     => ['Хетта_дола_хувцамаш', 'ВӀаший_дувзаденна_дола_хувцамаш'],
    'Revisiondelete'          => ['Тоадар_дӀадаккхар'],
    'Search'                  => ['Лахаp'],
    'Shortpages'              => ['Лоаца_оагӀонаш'],
    'Specialpages'            => ['ЛаьрххӀа_йола_оагӀонаш'],
    'Statistics'              => ['Статистика'],
    'Tags'                    => ['Фосташ'],
    'Unblock'                 => ['Блок_юхаяккхар'],
    'Uncategorizedcategories' => ['ОагӀаташ_йоаца_оагӀаташ'],
    'Uncategorizedimages'     => ['ОагӀаташ_йоаца_файлаш'],
    'Uncategorizedpages'      => ['ОагӀаташ_йоаца_оагӀонаш'],
    'Uncategorizedtemplates'  => ['ОагӀаташ_йоаца_лераш'],
    'Undelete'                => ['Меттаоттае', 'Юхаметтаоттае', 'Меттаоттаде', 'Юхаметтаоттаде'],
    'Unlockdb'                => ['Дарий_базанна_теха_блок_юхаяккхар'],
    'Unusedcategories'        => ['Лелаеш_йоаца_оагӀаташ'],
    'Unusedimages'            => ['Лелаеш_йоаца_файлаш'],
    'Unusedtemplates'         => ['Леладеш_доаца_лераш'],
    'Upload'                  => ['Чудаккхар'],
    'UploadStash'             => ['Къайла_дола_чудаккхар'],
    'Userlogin'               => ['Чу', 'Чувала'],
    'Userlogout'              => ['Ара', 'Аравала', 'Болх_чакхбаккхар'],
    'Userrights'              => ['Бокъоношта_урхалде'],
    'Version'                 => ['Эрш', 'Верси'],
    'Wantedcategories'        => ['Эшаш_йола_оагӀаташ'],
    'Wantedfiles'             => ['Эшаш_йола_файлаш'],
    'Wantedpages'             => ['Эшаш_йола_оагӀонаш'],
    'Wantedtemplates'         => ['Эшаш_дола_лераш'],
    'Watchlist'               => ['Зем-мугӀам', 'Зема_мугӀам'],
    'Whatlinkshere'           => ['ТӀатовжамаш_укхазахьа', 'Укхазахьа_дола_тӀатовжамаш'],
    'Withoutinterwiki'        => ['Интервики_йоацаш'],
];

$linkTrail = '/^([a-zабвгдеёжзийклмнопрстуфхцчшщъыьэюяӀ]+)(.*)$/sDu';
