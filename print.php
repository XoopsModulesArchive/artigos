<?php

// $Id: print.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
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
//$use_xoops_codes = 1; // for testing only
$myts = MyTextSanitizer::getInstance();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // this page uses smarty template

    // this must be set before including main header.php

    #$GLOBALS['xoopsOption']['template_main'] = 'artigo_item.html';

    #require XOOPS_ROOT_PATH.'/header.php';

    //$xoopsTpl->assign('index_page_title', _MD_INDEX_PAGE_TITLE);

    //$xoopsTpl->assign('category_list_title', _MD_CATLIST_TITLE);

    // put html here

    html_header(); ?>

    <table class="maintbl">
        <tr>
            <td>


                <?php
                $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_main') . ' WHERE id=' . $id . ' AND art_validated=1 AND art_showme=1 ORDER BY id LIMIT 1');

    $result = $xoopsDB->query($sql);

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        //$artigo   = array();

        $artigo_id = $myrow['id'];

        $artigo_title = $myrow['art_title'];

        $artigo_description = $myrow['art_description'];

        if (1 == $use_xoops_codes) {
            $artigo_text = $myts->displayTarea($myrow['art_artigo_text']);
        } else {
            $artigo_text = $myrow['art_artigo_text'];
        }

        $posted = post_date($myrow['art_posted_datetime'], 'D d M Y');

        //echo $xoopsConfig['sitename'];
                    ?>

                    <table border="0">
                        <tr>
                            <td><strong>artigo title:</strong> &nbsp;</td>
                            <td><?= $artigo_title ?></td>
                        </tr>
                        <tr>
                            <td><strong>First posted:</strong> &nbsp;</td>
                            <td><?= $posted ?></td>
                        </tr>
                        <tr>
                            <td><strong>Description:</strong> &nbsp;</td>
                            <td><?= $artigo_description ?></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <tr>
                            <td>
                                <?= $artigo_text ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td colspan="2"><strong>This artigo was originally published on:</strong></td>
                        </tr>
                        <tr>
                            <td width="100"><strong>Site:</strong></td>
                            <td><?= $xoopsConfig['sitename'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>URL:</strong></td>
                            <td><a href="<?= XOOPS_URL ?>/modules/artigos/artigo.php?id=<?= $id ?>"><?= XOOPS_URL ?>/modules/artigos/artigo.php?id=<?= $id ?></a></td>
                        </tr>
                    </table>

                    <?php
                    #$artigo = array('id' => $myrow['id'], 'artigo_title' => $myrow['art_title'], 'art_artigo_text' => $myrow['art_artigo_text'], 'art_views' => $myrow['art_views'], 'art_posted_datetime' => post_date($myrow['art_posted_datetime'], "D d M Y"));
    } ?>

            </td>
        </tr>
    </table>

    <?php
    // html footer
    html_footer();
} // end if

################################################################################
# functions
#
function html_header()
{
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 TRANSITIONAL//EN">
    <html>
    <head>
        <title></title>
        <style type="text/css">
            <!--
            body {
                font-family: "Times New Roman", Times, serif;
                font-size: 12pt;
                color: Black;
            }

            table.maintbl {
                border-style: solid;
                border-width: 1px;
                border-color: Black;
                width: 90%;
                margin-left: 5%;
                margin-right: 5%;
            }

            -->
        </style>

        <script language="Javascript1.2">
            <!--
            function printpage() {
                window.print();
            }

            //-->
        </script>

    </head>
    <body onload="printpage()">

    <?php
} // end function

################################################################################
#
function html_footer()
{
    ?>

    </body>
    </html>
    <?php
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

#require XOOPS_ROOT_PATH.'/include/comment_view.php';
#require XOOPS_ROOT_PATH.'/footer.php';
?>
