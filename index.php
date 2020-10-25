<?php

// $Id: index.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
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
$myts = MyTextSanitizer::getInstance();

if (!isset($_GET['artid'])) {
    // this page uses smarty template

    // this must be set before including main header.php

    $GLOBALS['xoopsOption']['template_main'] = 'artigo_index.html';

    require XOOPS_ROOT_PATH . '/header.php';

    $xoopsTpl->assign('index_page_title', _MD_INDEX_PAGE_TITLE);    // Page title
    $xoopsTpl->assign('category_list_title', _MD_CATLIST_CAPTION);    // table header caption
    $xoopsTpl->assign('artigo_views_caption', _MD_ARTIGO_VIEW_CAP);            // artigo views
    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('artigos_cat') . ' WHERE cat_showme=1 ORDER BY cat_weight ASC');

    while (list($id, $parent_id, $cat_name, $cat_description) = $xoopsDB->fetchRow($result)) {
        $category = [];

        $category['cat_name'] = $cat_name; //htmlspecialchars($cat_name);

        $category['id'] = $id;

        $category['cat_description'] = $cat_description;

        $sql = 'SELECT * FROM ' . $xoopsDB->prefix('artigos_main') . ' WHERE art_showme=1 AND art_cat_id=' . $id . ' ORDER BY art_weight ASC';

        $result2 = $xoopsDB->query($sql);

        while (false !== ($myrow = $xoopsDB->fetchArray($result2))) {
            $category['artigos'][] = ['id' => $myrow['id'], 'title' => htmlspecialchars($myrow['art_title'], ENT_QUOTES | ENT_HTML5), 'artigo_description' => $myts->displayTarea($myrow['art_description']), 'artigo_views' => $myrow['art_views']];
        }

        $xoopsTpl->append_by_ref('categories', $category);

        unset($category);
    }
} // end if

require XOOPS_ROOT_PATH . '/footer.php';
