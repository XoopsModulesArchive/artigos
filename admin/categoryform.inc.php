<?php

// $Id: categoryform.inc.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
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

// set a default of zero for category order.
if (!isset($cat_weight)) {
    $cat_weight = 0;
}
// If cat_showme is set while in "edit mode", make sure the checkbox is selected.
if (1 == $cat_showme) {
    $checked = 'checked';
} else {
    $checked = '';
}
if (1 != $isedit) {
    $checked = 'checked';
}

echo '
  <tr>
    <td class="head">' . _AM_FORMCAPTIONTITLE . '</td>
    <td class="even"><input type="text" name="formdata[cat_name]" value="' . $cat_name . '" size="30" maxlength="50"></td>
  </tr>
  <tr>
    <td class="head">' . _AM_FORMCAPTIOORDER . '</td>
    <td class="even"><input type="text" name="formdata[cat_weight]" value="' . $cat_weight . '" size="2" maxlength="5"></td>
  </tr>
  <tr>
    <td class="head">' . _AM_FORMCAPTIODISPLAY . '</td>
    <td class="even"><input type="checkbox" name="formdata[cat_showme]" value="1"' . $checked . '></td>
  </tr>
  <tr>
    <td valign="top" class="head">' . _AM_FORMCAPTIODESCR . '</td>
    <td class="even">
      <!-- <textarea name="data[cat_description]" rows="10" cols="30"></textarea> -->
';
// call form text area function
xoopsCodeTarea('cat_description', 60, 10);
// call smilies function.
xoopsSmilies('cat_description');
echo '    
    </td>
  </tr>
  <tr>
    <td class="head">&nbsp;</td>
    <td class="even">
      <input type="hidden" name="op" value="' . $op . '">
      <input type="hidden" name="subop" value="add">
      <input type="hidden" name="formdata[cat_id]" value="' . $cat_id . '">
      <input type="submit" value="' . _AM_FORMBUTTONSUB . '"> 
      <input type="reset" value="' . _AM_FORMBUTTONRES . '">
    </td>
  </tr>
</table>
</form> 
';
