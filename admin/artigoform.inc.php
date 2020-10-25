<?php

// $Id: artigoform.inc.php,v 1.1 2006/03/28 04:08:10 mikhail Exp $
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

echo '

  <tr>
    <td>
      <table width="100%" border="0" cellpadding="4" cellspacing="1">
        <tr>
          <td nowrap="nowrap" class="head">' . _AM_FORMCAPTIONTITLE . " </td>
          <td class=\"even\">
            <input type=\"text\" name=\"art_title\" value=\"$art_title\" size=\"40\" maxlength=\"255\">
          </td>
        </tr>
        <tr>
          <td nowrap=\"nowrap\" class=\"head\">" . _AM_FORMCAPTIONCAT . '</td>
          <td class="even">';
listcats($art_cat_id);
echo '</td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="head">' . _AM_FORMCAPTIOORDER . ' </td>';
if (!isset($art_weight)) {
    $art_weight = 0;
}
echo " 
          <td class=\"even\"><input type=\"text\" name=\"art_weight\" value=\"$art_weight\" size=\"4\" maxlength=\"3\"></td>
        </tr>
        <tr>
          <td nowrap=\"nowrap\" class=\"head\">" . _AM_FORMCAPTIODISPLAY . ' </td>
          <td class="even">';

//$art_showme_checked = ($art_showme == 1) ? " checked=\"checked\"" : "";
if (!isset($art_showme)) {
    $art_showme_checked = 'checked';
} else {
    $art_showme_checked = (1 == $art_showme) ? ' checked="checked"' : '';
}

echo "
            <input type=\"checkbox\" name=\"art_showme\" value=\"1\" $art_showme_checked>
          </td>
        </tr>
        <tr>
          <td nowrap=\"nowrap\" valign=\"top\" class=\"head\">" . _AM_FORMCAPTIODESCR . '</td>
          <td class="even">
';
// call form text area function
xoopsCodeTarea('art_description', 60, 10);
echo '
          
          </td>
        </tr>        
        <tr>
          <td nowrap="nowrap" valign="top" class="head">' . _AM_FORMCAPTIONTEXT . ' </td>
          <td class="even">
';

// call form text area function
xoopsCodeTarea('art_artigo_text', 60, 20);
// call smilies function.
xoopsSmilies('art_artigo_text');

//if ($art_nohtml == 1) { $nohtml_checked = "checked"; }
$nohtml_checked = (1 == $art_nohtml) ? ' checked="checked"' : '';
echo "<br><input type=\"checkbox\" name=\"art_nohtml\" value=\"1\" $nohtml_checked> " . _AM_FORMCAPTIONNOHTML . '<br>';

//if ($art_nosmiley == 1) { $nosmiley_checked = "checked"; }
$nosmiley_checked = (1 == $art_nosmiley) ? ' checked="checked"' : '';
echo "<input type=\"checkbox\" name=\"art_nosmiley\" value=\"1\" $nosmiley_checked> " . _AM_FORMCAPTIONNOSMILEY . '<br>';

//if ($art_noxcode == 1) { $noxcode_checked = "checked"; }
$noxcode_checked = (1 == $art_noxcode) ? ' checked="checked"' : '';
echo "<input type=\"checkbox\" name=\"art_noxcode\" value=\"1\" $noxcode_checked> " . _AM_FORMCAPTIONNOXCODE . '

          </td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="head">&nbsp;</td>
          <td class="even">
            <input type="hidden" name="art_id" value="' . $id . '">
            <input type="hidden" name="op" value="' . $op . '">
            <input type="hidden" name="art_author_id" value="' . $art_author_id . '">
            <input type="hidden" name="art_author_ip" value="' . $art_author_ip . '">
            <input type="hidden" name="art_posted_datetime" value="' . $art_posted_datetime . '">
            <input type="hidden" name="art_validated" value="' . $art_validated . '">
            <input type="hidden" name="art_views" value="' . $art_views . '">
            <!-- <input type="submit" name="artigo_preview" value="' . _PREVIEW . '"> -->
            <input type="submit" name="artigo_submit" value="' . _AM_FORMBUTTONSUB . '">
            <input type="reset" value="' . _AM_FORMBUTTONRES . '">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>';
