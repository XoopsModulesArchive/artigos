<?php

// $Id: main.php,v 1.1 2006/03/28 04:08:13 mikhail Exp $

// German version - Thanks to Frank Black (some later changes made by Andrew
//                  Mills using Google's transloation tool.)

// Cat/artigo listing index.
define('_MD_CATLIST_CAPTION', 'Artikel');            // Caption of category/artigo list
define('_MD_INDEX_PAGE_TITLE', 'Index Seitentitel');    // Title of category/artigo list page (not used in shipped package)
define('_MD_ARTIGO_VIEW_CAP', 'Ansichten');            // Caption for number of views

// artigo page
define('_MD_INDEXLINKTEXT', 'Index');                // Text for return to index page
define('_MD_INDEXLINKPRINT', 'Druck');                // Text for printable version
define('_MD_POSTEDON', 'An bekanntgegeben');    // Posted on text
define('_MD_READS', 'liest');                // Text for reads

// General
define('_MD_MOD_WHOBY', '<span style="font-size: smaller; text-align: center;">artigos Copyright &copy 2005 <a href="ajmills@the-crescent.net">Andrew Mills</a></span>');

// Confirmation messages
define('_MD_DBUPDATED', 'Datenbank wurde erfolgreich aktualisiert!');
define('_MD_DBNOTUPDATED', 'Datenbank wurde nicht aktualisiert!');
define('_MD_ITEMDELETED', 'Artikel wurde erfolgreich gel&ouml;scht!');
define('_MD_ITEMNOTDELETED', 'Einzelteil nicht erfolgreich gelöscht!');
define('_MD_ITEM_DELETED_CANCELLED', 'L&ouml;schen abgebrochen!');
define('_MD_CONFIRMDELETE', 'Sind Sie Sie möchten dieses Einzelteil löschen sicher?');
