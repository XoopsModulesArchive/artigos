<?php

// $Id: artigo.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
//  ------------------------------------------------------------------------ //
//  Author: Andrew Mills                                                     //
//  Email:  ajmills@the-crescent.net                                         //
//	About:  This file is part of the artigos module for Xoops v2.           //
//                                                                           //
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://xoopscube.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

require __DIR__ . '/header.php';
require __DIR__ . '/include/config.php';

$myts = MyTextSanitizer::getInstance();
//$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
//if ($cat_id < 1) {
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // this page uses smarty template

    // this must be set before including main header.php

    $GLOBALS['xoopsOption']['template_main'] = 'artigo_item.html';

    require XOOPS_ROOT_PATH . '/header.php';

    $xoopsTpl->assign('index_link_text', _MD_INDEXLINKTEXT);    // Link text back to index.
    $xoopsTpl->assign('print_art_link', _MD_INDEXLINKPRINT);    // Text for print link
    $xoopsTpl->assign('posted_on', _MD_POSTEDON);                // Posted on text
    $xoopsTpl->assign('art_reads_cap', _MD_READS);                // Text for reads

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_main') . ' WHERE id=' . $id . ' AND art_validated=1 AND art_showme=1 ORDER BY id LIMIT 1');

    $result = $xoopsDB->query($sql);

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        //$artigo   = array();

        //$artigo_id                = $myrow['id'];

        //$artigo_title         = $myrow['art_title'];

        //$artigo_description   = $myrow['art_description'];

        //$artigo_text			= $myrow['art_artigo_text'];

        //$posted = post_date($myrow['art_posted_datetime']), "Y");

        $xoopsTpl->assign('artigo_id', $myrow['id']);

        if (1 == $use_xoops_codes) {
            $artigo = ['id' => $myrow['id'], 'artigo_title' => $myrow['art_title'], 'art_artigo_text' => $myts->displayTarea($myrow['art_artigo_text']), 'art_views' => $myrow['art_views'], 'art_posted_datetime' => post_date($myrow['art_posted_datetime'], 'D d M Y')];
        } else {
            $artigo = ['id' => $myrow['id'], 'artigo_title' => $myrow['art_title'], 'art_artigo_text' => $myrow['art_artigo_text'], 'art_views' => $myrow['art_views'], 'art_posted_datetime' => post_date($myrow['art_posted_datetime'], 'D d M Y')];
        }
    }

    $xoopsTpl->append_by_ref('artigos', $artigo);

    unset($artigo);

    increment_artigo_views($id);

    //}
} // end if

################################################################################
# functions
# art_view_count() no longer used, only here for reference.
function art_view_count($art_id)
{
    global $xoopsDB;

    //global $xoopsModule;

    $result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('artigos_main') . " WHERE id = '$art_id'");

    [$artigoviews] = $xoopsDB->fetchRow($result);

    return $artigoviews;
} // end function

################################################################################
#
function post_date($datetime, $format)
{
    // DateTime format:  YYYY-MM-DD hh:mm:ss

    $yr = (string)mb_substr($datetime, 0, 4);

    $mo = (string)mb_substr($datetime, 5, 2);

    $da = (string)mb_substr($datetime, 8, 2);

    $hr = (string)mb_substr($datetime, 11, 2);

    $mi = (string)mb_substr($datetime, 14, 2);

    $se = (string)mb_substr($datetime, 17, 2);

    $date_format = date($format, mktime($hr, $mi, $se, $mo, $da, $yr)); //." GMT";

    return $date_format;
} // end function

################################################################################
# functions
# art_view_count() no longer used, only here for reference.
function increment_artigo_views($id)
{
    global $xoopsDB;

    //global $xoopsModule;

    //$xoopsDB->query("UPDATE ".$xoopsDB->prefix("artigos_main")." SET art_views=art_views+1 where id='$id'");

    //$xoopsDB->queryF("UPDATE ".$xoopsDB->prefix("seccont")." SET counter=counter+1 WHERE artid=$artid");

    $sql = ('UPDATE ' . $xoopsDB->prefix('artigos_main') . " SET art_views=art_views+1 WHERE id=$id");

    $xoopsDB->queryF($sql);

    //if ($xoopsDB->query($q)){
    //        fc_admin_message(_FC_EDIT_DONE,0,"");

    //return $artigoviews;
} // end function
# end of functions
################################################################################

require XOOPS_ROOT_PATH . '/include/comment_view.php';
require XOOPS_ROOT_PATH . '/footer.php';
