<?php

// $Id: xoops_version.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
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

// Any copyright notice, instructions, etc...
$modversion['name'] = _MI_ARTIGOS_NAME;
$modversion['version'] = 0.06;
$modversion['description'] = _MI_ARTIGOS_DESC;
$modversion['credits'] = '';
$modversion['author'] = 'Andrew Mills';
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'modulelogo.png';
$modversion['dirname'] = 'artigos';

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminmenu'] = '';

// Menu
$modversion['hasMain'] = 1;

// Templates
$modversion['templates'][1]['file'] = 'artigo_index.html'; // main index
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'artigo_item.html'; // view artigo
$modversion['templates'][2]['description'] = '';

// Blocks
//$modversion['blocks'][1]['file']		= "menu_block.php";
//$modversion['blocks'][1]['name']		= _MI_ARTIGOS_BNAME1;
//$modversion['blocks'][1]['description']	= "Shows Norton AV info";
//$modversion['blocks'][1]['show_func']	= "nav_info_show";
//$modversion['blocks'][1]['template']	= 'news_block_topics.html';

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'artigos_cat';
$modversion['tables'][1] = 'artigos_main';
$modversion['tables'][2] = 'artigos_rating';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'artigo.php';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'artigos_search';