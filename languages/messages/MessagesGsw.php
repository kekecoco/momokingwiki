<?php
/** Swiss German (Alemannisch)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @file
 * @ingroup Languages
 */

$fallback = 'de';

/** @phpcs-require-sorted-array */
$specialPageAliases = [
    'Allmessages'             => ['Alli_Nochrichte'],
    'Allpages'                => ['Alli_Syte'],
    'Ancientpages'            => ['Veralteti_Syte'],
    'Badtitle'                => ['Nit-gültige_Sytename'],
    'Blankpage'               => ['Läärsyte'],
    'Block'                   => ['Sperre'],
    'BlockList'               => ['Gsperrti_IP'],
    'Booksources'             => ['ISBN-Suech'],
    'BrokenRedirects'         => ['Kaputti_Wyterlaitige'],
    'Categories'              => ['Kategorie'],
    'ChangeEmail'             => ['E-Mai-Adräss_ändere'],
    'ChangePassword'          => ['Passwort_ändre'],
    'ComparePages'            => ['Syte_verglyyche'],
    'Confirmemail'            => ['E-Mail_bstetige'],
    'Contributions'           => ['Byytreeg'],
    'CreateAccount'           => ['Benutzerchonto_aaleege'],
    'Deadendpages'            => ['Sackgassesyte'],
    'DeletedContributions'    => ['Gleschti_Byytreeg'],
    'DoubleRedirects'         => ['Doppleti_Wyterlaitige'],
    'EditWatchlist'           => ['Bearbeitigslischt_bearbeite'],
    'Emailuser'               => ['E-Mail'],
    'ExpandTemplates'         => ['Vorlage_expandiere'],
    'Export'                  => ['Exportiere'],
    'Fewestrevisions'         => ['Syte_wo_am_wenigschte_bearbeitet_sin'],
    'FileDuplicateSearch'     => ['Datei-Duplikat-Suech'],
    'Filepath'                => ['Dateipfad'],
    'Import'                  => ['Importiere'],
    'Invalidateemail'         => ['E-Mail_nit_bstetige'],
    'LinkSearch'              => ['Suech_no_Links'],
    'Listadmins'              => ['Ammanne'],
    'Listbots'                => ['Bötli'],
    'Listfiles'               => ['Dateie'],
    'Listgrouprights'         => ['Grupperächt'],
    'Listredirects'           => ['Wyterleitige'],
    'Listusers'               => ['Benutzerlischte'],
    'Lockdb'                  => ['Datebank_sperre'],
    'Log'                     => ['Logbuech'],
    'Lonelypages'             => ['Verwaisti_Syte'],
    'Longpages'               => ['Langi_Syte'],
    'MergeHistory'            => ['Versionsgschichte_zämefiere'],
    'MIMEsearch'              => ['MIME-Suech'],
    'Mostcategories'          => ['Syte_wo_am_meischte_kategorisiert_sin'],
    'Mostimages'              => ['Dateie_wo_am_meischte_brucht_wäre'],
    'Mostlinked'              => ['Syte_wo_am_meischte_druff_verlinkt_isch'],
    'Mostlinkedcategories'    => ['Kategorie_wo_am_meischte_brucht_wäre'],
    'Mostlinkedtemplates'     => ['Vorlage_wo_am_meischte_brucht_wäre'],
    'Mostrevisions'           => ['Syte_wo_am_meischte_bearbeitet_sin'],
    'Movepage'                => ['Verschiebe'],
    'Mycontributions'         => ['Myyni_Byytreeg'],
    'MyLanguage'              => ['Myyni_Sprooch'],
    'Mypage'                  => ['Myyni_Benutzersyte'],
    'Mytalk'                  => ['Myyni_Diskussionssyte'],
    'Myuploads'               => ['Dateie_wonni_uffeglade_han'],
    'Newimages'               => ['Neji_Dateie'],
    'Newpages'                => ['Neji_Syte'],
    'PasswordReset'           => ['Passwort_zruggsetze'],
    'PermanentLink'           => ['Permalink'],
    'Preferences'             => ['Ystellige'],
    'Prefixindex'             => ['Vorsilbeverzeichnis'],
    'Protectedpages'          => ['Gschitzti_Syte'],
    'Protectedtitles'         => ['Gsperrti_Titel'],
    'RandomInCategory'        => ['Zuefelligi_Kategori'],
    'Randompage'              => ['Zuefelligi_Syte'],
    'Randomredirect'          => ['Zuefelligi_Wyterleitig'],
    'Recentchanges'           => ['Letschti_Änderige'],
    'Recentchangeslinked'     => ['Änderige_an_verlinkte_Syte'],
    'Revisiondelete'          => ['Versionsleschig'],
    'Search'                  => ['Suech'],
    'Shortpages'              => ['Churzi_Syte'],
    'Specialpages'            => ['Spezialsyte'],
    'Statistics'              => ['Statischtik'],
    'Tags'                    => ['Markierige'],
    'Unblock'                 => ['Freigee'],
    'Uncategorizedcategories' => ['Kategorie_wo_nit_kategorisiert_sin'],
    'Uncategorizedimages'     => ['Dateie_wo_nit_kategorisiert_sin'],
    'Uncategorizedpages'      => ['Syte_wo_nit_kategorisiert_sin'],
    'Uncategorizedtemplates'  => ['Vorlage_wo_nit_kategorisiert_sin'],
    'Undelete'                => ['Widerhärstelle'],
    'Unlockdb'                => ['Sperrig_vu_dr_Datebank_ufhebe'],
    'Unusedcategories'        => ['Kategorie_wo_nit_brucht_wäre'],
    'Unusedimages'            => ['Dateie_wo_nit_brucht_wäre'],
    'Unusedtemplates'         => ['Vorlage_wo_nit_brucht_wäre'],
    'Unwatchedpages'          => ['Syte_wu_nit_beobachtet_wäre'],
    'Upload'                  => ['Uffelade'],
    'Userlogin'               => ['Amälde'],
    'Userlogout'              => ['Abmälde'],
    'Userrights'              => ['Benutzerrächt'],
    'Wantedcategories'        => ['Kategorie_wo_gwinscht_sin'],
    'Wantedfiles'             => ['Dateie_wo_fähle'],
    'Wantedpages'             => ['Syte_wo_gwinscht_sin'],
    'Wantedtemplates'         => ['Vorlage_wo_fähle'],
    'Watchlist'               => ['Beobachtigslischte'],
    'Whatlinkshere'           => ['Was_verwyyst_do_druff?'],
    'Withoutinterwiki'        => ['Ohni_Interwiki'],
];

/** @phpcs-require-sorted-array */
$magicWords = [
    'displaytitle' => ['1', 'SYTETITEL', 'SEITENTITEL', 'DISPLAYTITLE'],
];

$linkTrail = '/^([äöüßa-z]+)(.*)$/sDu';
