<?php

// $Id: artigos.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
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

require_once dirname(__DIR__, 3) . '/include/cp_header.php';
if (file_exists('../language/' . $xoopsConfig['language'] . '/main.php')) {
    include '../language/' . $xoopsConfig['language'] . '/main.php';
} else {
    include '../language/english/main.php';
}
require_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';

// Take and process form stuff.
if (isset($_GET['op'])) {
    $op = $_GET['op'];
}
if (isset($_POST['op'])) {
    $op = $_POST['op'];
}
if (isset($_POST['subop'])) {
    $subop = $_POST['subop'];
}

switch ($op) {
    case 'addartigo': // Form stuff to add artigo
        xoops_cp_header();
        if (isset($_POST)) {
        }
        addartigo($_POST);

       break;
    case 'editartigo': // Form stuff to edit artigo
        xoops_cp_header();
        //echo "edit artigo area";
        if (isset($_GET['art_id'])) {
            $art_id = $_GET['art_id'];
        }
        //$op = "updatedartigo";
        echo '
                <br>
				<form action="artigos.php" method="post">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <th colspan="2">' . _AM_FORMEDITARTTITLE . '</th>
                    </tr>
				';
        editartigo($art_id);

       break;
    case 'updatedartigo':
        xoops_cp_header();
        if (isset($_POST)) {
        }
        updatedartigo($_POST);
        //echo "updated";
        break;
    case 'delartigo': // Delete artigo
        xoops_cp_header();
        //echo "delete artigo area";

        if (isset($_POST['art_id'])) {
            $art_id = $_POST['art_id'];
        }
        if (isset($_GET['art_id'])) {
            $art_id = $_GET['art_id'];
        }

        if ('delok' == $subop) {
            //echo "hello, deleted your thing be will - id: " . $art_id;

            $sql = sprintf('DELETE FROM %s WHERE id = %u', $xoopsDB->prefix('artigos_main'), $art_id);

            if ($xoopsDB->queryF($sql)) {
                // delete comments for the artigo being deleted

                xoops_comment_delete($xoopsModule->getVar('mid'), $art_id);

                redirect_header('artigos.php', 1, _MD_ITEMDELETED);

            //echo "deleted";
            } else {
                redirect_header('artigos.php', 1, _MD_ITEMNOTDELETED);

                //echo "not deleted";
            }
        } // end if
        else {
            xoops_confirm(['op' => 'delartigo', 'art_id' => $art_id, 'subop' => 'delok'], 'artigos.php', _MD_CONFIRMDELETE);
        }

        //xoops_cp_footer();
        break;
    // Default view
    default:
        xoops_cp_header();
        // default page view
        $op = 'addartigo';
        listartigo();
        echo '
                <br>
				<form action="artigos.php" method="post">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <th colspan="2">' . _AM_FORMADDARTTITLE . '</th>
                    </tr>
				';
        include 'artigoform.inc.php';
        // following line for DHTML tooltip category info.
        echo '<div id="navtxt" class="navtext" style="visibility:hidden; position:absolute; top:0px; left:-400px; z-index:10000; padding:2px"></div>';

       break;
} // end switch

################################################################################
################################################################################
# Functions and stuff

################################################################################
# List artigos

function listartigo()
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_main') . ' ORDER BY art_cat_id, art_weight ASC');

    $result = $xoopsDB->query($sql);

    echo "
<!-- Note:  is there a way of putting this in Xoop's admin header section? -->
<style type=\"text/css\">
<!--
.navtext {
width: 150px;
font-size: 12px;
border-width: 2px;
border-style: outset;
border-color: darkgray;
layer-background-color: #E9E9E9;
background-color: #E9E9E9;
color: black;
}
-->
</style>
<script language=\"javascript\" src=\"alttxt.js\">
/***********************************************
* Popup Information Box III-By Brian Gosselin at http://scriptasylum.com/bgaudiodr/
* Script featured on Dynamic Drive (http://www.dynamicdrive.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
  <table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" width=\"100%\">
    <tr>
      <th colspan=\"7\">" . _AM_LISTARTTITLE . '</th>
    </tr>
    <tr>
      <td class="head" width="30" style="text-align: center;">' . _AM_FORMHDRID . '</td>
      <td class="head" width="150" style="text-align: center;">' . _AM_FORMHDRTITLE . '</td>
      <td class="head" style="text-align: center;">' . _AM_FORMHDRDESC . '</td>
      <td class="head" width="30" style="text-align: center;">' . _AM_FORMHDRCATNAMESHORT . '</td>
      <td class="head" width="35" style="text-align: center;">' . _AM_FORMHDRORDER . '</td>
      <td class="head" width="50" style="text-align: center;">' . _AM_FORMHDREDIT . '</td>
      <td class="head" width="50" style="text-align: center;">' . _AM_FORMHDRDEL . '</td>
    </tr>
';

    $rowclass = 'even'; // set default call to use for rows

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        //$myrow = $xoopsDB->fetchArray($result);

        $id = $myrow['id'];

        $art_title = $myrow['art_title'];

        $art_description = mb_substr($myts->displayTarea($myrow['art_description']), 0, 40) . '[...]';

        //$art_artigo_text      = $myts->displayTarea($myrow['art_artigo_text']);

        $art_cat_id = $myrow['art_cat_id'];

        $art_posted_datetime = $myrow['art_posted_datetime'];

        $art_showme = $myrow['art_showme'];

        $art_weight = $myrow['art_weight'];

        $art_nohtml = $myrow['art_nohtml'];

        $art_nosmiley = $myrow['art_nosmiley'];

        $art_noxcode = $myrow['art_noxcode'];

        if ('even' == $rowclass) {
            $rowclass = 'odd';
        } else {
            $rowclass = 'even';
        }

        echo '

    <tr>
      <td class="' . $rowclass . "\" style=\"text-align: center;\">$id</td>
      <td class=\"" . $rowclass . "\">$art_title</td>
      <td class=\"" . $rowclass . "\">$art_description</td>
      <td class=\"" . $rowclass . '" style="text-align: center;">' . cat_info($art_cat_id) . "<!--$art_cat_id--></td>
      <td class=\"" . $rowclass . "\" style=\"text-align: center;\">$art_weight</td>
      <td class=\"" . $rowclass . "\" style=\"text-align: center;\"><a href=\"artigos.php?op=editartigo&amp;art_id=$id\">" . _AM_LINKEDIT . '</a></td>
      <td class="' . $rowclass . "\" style=\"text-align: center;\"><a href=\"artigos.php?op=delartigo&amp;art_id=$id\">" . _AM_LINKDEL . '</a></td>
    </tr>

';
    } // end while

    echo '
  </table>
';
} // end listartigo

################################################################################
# Add artigo data

function addartigo($formdata)
{
    global $xoopsDB;

    // Notes: get IP address, add time (NULL), get browser details, USER ID

    // debug line

    //echo "<pre>"; print_r($formdata); echo "</pre>";

    //id

    //art_author_id

    //art_author_ip

    $art_cat_id = $formdata['art_cat_id'];

    $art_title = $formdata['art_title'];

    $art_description = $formdata['art_description'];

    $art_artigo_text = $formdata['art_artigo_text'];

    //$art_posted_datetime = ** not used - NULL

    $art_validated = '1';

    $art_showme = $formdata['art_showme'];

    $art_views = '0';

    //$art_last_update    = ** not used - NULL
    $art_last_update_by = '0'; // not used yet
    $art_last_update_ip = '000.000.000.000'; // not used yet
    $art_weight = $formdata['art_weight'];

    $contents_nohtml = $formdata['contents_nohtml'];

    $contents_nosmiley = $formdata['contents_nosmiley'];

    $contents_noxcode = $formdata['contents_noxcode'];

    $sql = 'INSERT INTO '
           . $xoopsDB->prefix('artigos_main')
           . " VALUES (NULL, 0, 0, '$art_cat_id', '$art_title', '$art_description', '$art_artigo_text', NOW(), '$art_validated', '$art_showme', '$art_views', NOW(), '$art_last_update_by', '$art_last_update_ip', '$art_weight', '$art_nohtml', '$art_nosmiley', '$art_noxcode')";

    if ($xoopsDB->query($sql)) {
        redirect_header('artigos.php', 2, _MD_DBUPDATED);

    //echo "entered";
    } else {
        redirect_header('artigos.php', 2, _MD_DBNOTUPDATED);

        //echo "not entered";
    }
} // end addartigo()

################################################################################
# Edit artigo

function editartigo($art_id)
{
    global $xoopsDB;

    global $art_description;

    global $art_artigo_text;

    $myts = MyTextSanitizer::getInstance();

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_main') . " WHERE id=$art_id LIMIT 1");

    $result = $xoopsDB->query($sql);

    //list( ,,,,$art_title, $art_description, $art_artigo_text, $art_posted_datetime, $art_validated, $art_showme, $art_views, $art_last_update, $art_last_update_by, $art_last_update_ip, $art_weight, $art_nohtml, $art_nosmiley, $art_noxcode) = $xoopsDB->fetchRow($result);

    //while($myrow = $xoopsDB->fetchArray($result)) {

    $myrow = $xoopsDB->fetchArray($result);

    $id = $myrow['id'];

    $art_author_id = $myrow['art_author_id'];

    $art_author_ip = $myrow['art_author_ip'];

    $art_posted_datetime = $myrow['art_posted_datetime'];

    $art_validated = $myrow['art_validated'];

    $art_title = $myrow['art_title'];

    $art_description = htmlspecialchars($myrow['art_description'], ENT_QUOTES | ENT_HTML5);

    $art_artigo_text = htmlspecialchars($myrow['art_artigo_text'], ENT_QUOTES | ENT_HTML5);

    $art_cat_id = $myrow['art_cat_id'];

    $art_posted_datetime = $myrow['art_posted_datetime'];

    $art_showme = $myrow['art_showme'];

    $art_views = $myrow['art_views'];

    $art_weight = $myrow['art_weight'];

    $art_nohtml = $myrow['art_nohtml'];

    $art_nosmiley = $myrow['art_nosmiley'];

    $art_noxcode = $myrow['art_noxcode'];

    //if ($art_showme == 1)   { $art_showme_checked = "checked"; }

    //if ($art_nohtml == 1)   { $nohtml_checked     = "checked"; }

    //if ($art_nosmiley == 1) { $nosmiley_checked   = "checked"; }

    //if ($art_noxcode == 1)  { $noxcode_checked    = "checked"; }

    $op = 'updatedartigo';

    include 'artigoform.inc.php';

    //} // end while

    //include "artigoform.inc.php";
} // end editartigo()

################################################################################
# Updated artigo data

function updatedartigo($formdata)
{
    global $xoopsDB;

    //echo "updated, like<br>";

    //echo "<pre>";

    //print_r($formdata);

    //echo "</pre>";

    $art_id = $formdata['art_id'];

    $art_author_id = $formdata['art_author_id'];

    $art_author_ip = $formdata['art_author_ip'];

    $art_cat_id = $formdata['art_cat_id'];

    $art_title = $formdata['art_title'];

    $art_description = $formdata['art_description'];

    $art_artigo_text = $formdata['art_artigo_text'];

    $art_posted_datetime = $formdata['art_posted_datetime'];

    $art_validated = '1';

    $art_showme = $formdata['art_showme'];

    $art_views = $formdata['art_views'];

    //$art_last_update    = * NOW() used in update below.
    $art_last_update_by = '0'; // not used yet
    $art_last_update_ip = '000.000.000.000'; // not used yet
    $art_weight = $formdata['art_weight'];

    $art_nohtml = $formdata['art_nohtml'];

    $art_nosmiley = $formdata['art_nosmiley'];

    $art_noxcode = $formdata['art_noxcode'];

    $sql = ('UPDATE '
               . $xoopsDB->prefix('artigos_main')
               . " SET id = '$art_id', art_author_id = '$art_author_id', art_author_ip = '$art_author_ip', art_cat_id = '$art_cat_id', art_title = '$art_title', art_description = '$art_description', art_artigo_text = '$art_artigo_text', art_posted_datetime = '$art_posted_datetime', art_validated = '$art_validated', art_showme = '$art_showme', art_views = '$art_views', art_last_update = NOW(), art_last_update_by = '$art_last_update_by', art_last_update_ip = '$art_last_update_ip', art_weight = '$art_weight', art_nohtml = '$art_nohtml', art_nosmiley = '$art_nosmiley', art_noxcode = '$art_noxcode' WHERE id=$art_id");

    $result = $xoopsDB->query($sql);

    if ($xoopsDB->query($sql)) {
        redirect_header('artigos.php', 2, _MD_DBUPDATED);

    //echo "entered";
    } else {
        redirect_header('artigos.php', 2, _MD_DBNOTUPDATED);

        //echo "not entered";
    }

    //xoops_cp_footer();
    //exit();
} // end function updatedartigo()

################################################################################
# List catagories (for artigo add/edit form)

function listcats($art_cat_id)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    //if (isset($art_cat_id)) { $sqlquery = ""; }

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_cat') . ' ORDER BY cat_name ASC');

    $result = $xoopsDB->query($sql);

    //$option_selected = ($art_cat_id == $cat_id) ? " selected" : "";

    echo "<select name=\"art_cat_id\">\n";

    echo '<option value="0">Please select a category</option>';

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $cat_id = $myrow['id'];

        $cat_name = $myrow['cat_name'];

        $option_selected = ($art_cat_id == $cat_id) ? ' selected' : '';

        echo "<option value=\"$cat_id\"$option_selected>$cat_name <!-- [aci $art_cat_id/ci $cat_id] --> </option>\n";
    } // end while

    //if (($art_cat_id != $cat_id) AND (isset($art_cat_id))) {

    //if ($art_cat_id != $cat_id) {

    //  echo "<option value=\"0\" selected>Orphaned artigo</option>\n";

    //}

    //if (isset($art_cat_id)) {

    //  echo "<option value=\"\">art id thingy set</option>\n";

    //}

    echo "</select>\n";
} // end function listcats()

################################################################################
# Provides info for DHTML pop on cat info. in art listing
function cat_info($cat_id)
{
    global $xoopsDB;

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_cat') . " WHERE id = $cat_id LIMIT 1");

    $result = $xoopsDB->query($sql);

    $myrow = $xoopsDB->fetchArray($result);

    //$cat_id  = $myrow['cat_id'];

    $cat_name = $myrow['cat_name'];

    //$cat_description  = $myrow['cat_description'];

    //echo "blah";

    //return "blah";

    return "<a href=\"#\" onmouseover=\"writetxt('" . $cat_name . ': ' . $cat_description . "')\" onmouseout=\"writetxt(0)\">$cat_id</a>";
}

################################################################################
xoops_cp_footer();
