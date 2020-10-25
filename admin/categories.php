<?php

// $Id: categories.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
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

require dirname(__DIR__, 3) . '/include/cp_header.php';
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

if (isset($_SERVER['PHP_SELF'])) {
    $thispage = $_SERVER['PHP_SELF'];
}

switch ($op) {
    case 'catedit': // Form functions for updating category
        xoops_cp_header();
        //$formdata = $_POST['formdata'];
        cat_edit();

       break;
    case 'catupdate': // Updated actual category data
        xoops_cp_header();
        cat_update();

       break;
    case 'catnewdata': // new category data
        xoops_cp_header();
        catnewdata();

       break;
    case 'catdelete': // delete category
        xoops_cp_header();
        $cat_id = $_GET['cat_id'];

        if (isset($_POST['confirm'])) {
            //echo "send to actual delete function";

            delete_category($_POST['cat_id']);
        } else {
            //echo "send to xoops confirm/redirect function";

            xoops_confirm(['op' => 'catdelete', 'cat_id' => $cat_id, 'confirm' => 'true'], 'categories.php', _MD_CONFIRMDELETE);
        }

       break;
    // Default view
    default:
        xoops_cp_header();
        list_cats();
        add_category();

       break;
} // end switch

################################################################################
################################################################################
# Functions and stuff

################################################################################
#  List categories
function list_cats($data)
{
    global $xoopsDB;

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_cat') . ' ORDER BY id');

    $result = $xoopsDB->query($sql);

    echo '
		<table border="0" width="100%" cellpadding="2" cellspacing="1" align="center">
          <tr>
            <th colspan="5">' . _AM_LISTCATTITLE . '</th>
          </tr>
		  <tr>
            <td class="head">' . _AM_FORMHDRID . '</td>
            <td class="head">' . _AM_FORMHDRCATNAME . '</td>
            <td class="head">' . _AM_FORMHDRORDER . '</td>
            <td class="head">' . _AM_FORMHDREDIT . '</td>
            <td class="head">' . _AM_FORMHDRDEL . '</td>
          </tr>
		';

    $rowclass = 'even'; // set default call to use for rows

    if ($xoopsDB->getRowsNum($result) > 0) {
        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            if ('even' == $rowclass) {
                $rowclass = 'odd';
            } else {
                $rowclass = 'even';
            }

            echo '
				<tr>
					<td width="20" class="' . $rowclass . '" style="text-align: center;">' . $myrow['id'] . '</td>
					<td class="' . $rowclass . '">' . $myrow['cat_name'] . '</td>
                    <td width="35" class="' . $rowclass . '">' . $myrow['cat_weight'] . '</td>
					<td width="35" class="' . $rowclass . "\" style=\"text-align: center;\"><a href=\"$thispage?op=catedit&amp;cat_id=" . $myrow['id'] . '">' . _AM_LINKEDIT . '</a></td>
					<td width="45" class="' . $rowclass . "\" style=\"text-align: center;\"><a href=\"$thispage?op=catdelete&amp;cat_id=" . $myrow['id'] . '">' . _AM_LINKDEL . '</a></td>
				</tr>
				';
        } // end while
    } // end if
    else {
        echo '
			<td colspan="4" class="odd" style="text-align: center;">There are currently no categories.</td>
			';
    }

    echo '
		</table>
		<br>
		';
} // end function

################################################################################
# Add a new category form
function add_category()
{
    global $xoopsDB;

    if (isset($_SERVER['PHP_SELF'])) {
        $thispage = $_SERVER['PHP_SELF'];
    }

    $myts = MyTextSanitizer::getInstance();

    echo "

<form method=\"post\" action=\"$thispage\">

<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" align=\"center\">
  <tr>
    <th colspan=\"2\">" . _AM_FORMADDCATTTL . '</th>
  </tr>
';

    $op = 'catnewdata';

    require_once 'categoryform.inc.php';
} // end function

################################################################################
#
function cat_edit()
{
    global $xoopsDB;

    global $cat_description;

    $myts = MyTextSanitizer::getInstance();

    if (isset($_SERVER['PHP_SELF'])) {
        $thispage = $_SERVER['PHP_SELF'];
    }

    if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];
    }

    //cat_id=7

    //echo $cat_id;

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('artigos_cat') . " WHERE id = $cat_id LIMIT 1");

    $result = $xoopsDB->query($sql);

    //while($myrow = $xoopsDB->fetchArray($result)) {

    $myrow = $xoopsDB->fetchArray($result);

    $cat_name = $myrow['cat_name'];

    $cat_description = htmlspecialchars($myrow['cat_description'], ENT_QUOTES | ENT_HTML5);

    $cat_weight = $myrow['cat_weight'];

    $cat_showme = $myrow['cat_showme'];

    //}

    $isedit = '1'; // set edit flag for form

    $op = 'catupdate';

    echo "
<br>
<form method=\"post\" action=\"$thispage\">

<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" align=\"center\">
  <tr>
    <th colspan=\"2\">" . _AM_FORMEDITCATTTL . '</th>
  </tr>
';

    require_once 'categoryform.inc.php';
} // end function cat_edit

################################################################################
# Do stuff with data from add form
function catnewdata()
{
    global $xoopsDB;

    if (isset($_POST['formdata'])) {
        $formdata = $_POST['formdata'];
    }

    $cat_description = $_POST['cat_description'] ?? '';

    //$id              = $formdata['id'];

    //$cat_parent_id   = $formdata['cat_parent_id'];

    $cat_name = $formdata['cat_name'];

    //$cat_description = $formdata['cat_description'];

    $cat_weight = $formdata['cat_weight'];

    $cat_showme = $formdata['cat_showme'];

    $sql = 'INSERT INTO ' . $xoopsDB->prefix('artigos_cat') . " VALUES (NULL, 0, '$cat_name', '$cat_description', '$cat_weight', '$cat_showme')";

    if ($xoopsDB->query($sql)) {
        redirect_header('categories.php', 2, _MD_DBUPDATED);

    //echo "entered";
    } else {
        redirect_header('categories.php', 2, _MD_DBNOTUPDATED);

        //echo "not entered";
    }
}

################################################################################
#

function cat_update()
{
    global $xoopsDB;

    if (isset($_POST['formdata'])) {
        $formdata = $_POST['formdata'];
    }

    if (isset($_POST['cat_description'])) {
        $cat_description = $_POST['cat_description'];
    }

    /* //debug bits
    echo "update thingy<br>";

    echo "<pre>";
    print_r ($formdata);
    echo "</pre>";
    echo $formdata['cat_id'];
    echo $cat_description;
    */

    $id = $formdata['cat_id'];

    $cat_parent_id = $formdata['cat_parent_id'];

    $cat_name = $formdata['cat_name'];

    //$cat_description = $formdata['cat_description'];

    $cat_weight = $formdata['cat_weight'];

    $cat_showme = $formdata['cat_showme'];

    $sql = ('UPDATE ' . $xoopsDB->prefix('artigos_cat') . " SET id = '$id', cat_parent_id = '$cat_parent_id', cat_name = '$cat_name', cat_description = '$cat_description', cat_weight = '$cat_weight', cat_showme = '$cat_showme' WHERE id=$id");

    $result = $xoopsDB->query($sql);

    if (!$result) {
        redirect_header('categories.php', 2, _MD_DBNOTUPDATED);

    //echo "update failed";
    } else {
        redirect_header('categories.php', 2, _MD_DBUPDATED);

        //echo "it appears to have updated, maybe";
    }
} // end function

################################################################################
# Delete categories
function delete_category($cat_id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $sql = sprintf('DELETE FROM %s WHERE id = %u', $xoopsDB->prefix('artigos_cat'), $cat_id);

    if ($xoopsDB->queryF($sql)) {
        redirect_header('categories.php', 2, _MD_DBUPDATED);

    //echo "deleted";
    } else {
        redirect_header('categories.php', 2, _MD_DBNOTUPDATED);

        //echo "not deleted";
    }
} // end function

################################################################################
xoops_cp_footer();
