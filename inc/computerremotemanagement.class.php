<?php

/*
   ------------------------------------------------------------------------
   FusionInventory
   Copyright (C) 2010-2016 by the FusionInventory Development Team.

   http://www.fusioninventory.org/   http://forge.fusioninventory.org/
   ------------------------------------------------------------------------

   LICENSE

   This file is part of FusionInventory project.

   FusionInventory is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   FusionInventory is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with FusionInventory. If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------

   @package   FusionInventory
   @author    David Durieux
   @co-author
   @copyright Copyright (c) 2010-2016 FusionInventory team
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @link      http://www.fusioninventory.org/
   @link      http://forge.fusioninventory.org/projects/fusioninventory-for-glpi/
   @since     2016

   ------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginFusioninventoryComputerRemoteManagement extends CommonDBTM {


   static $rightname = 'computer';


   static function getTypeName($nb=0) {
      return __('Remote management', 'fusioninventory');
   }

   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {

      if ($item->getID() > 0) {
         if (get_class($item) == 'Computer') {
            $nb = countElementsInTable('glpi_plugin_fusioninventory_computerremotemanagements',
                             "`computers_id`='".$item->getID()."'");
            if ($nb > 0) {
               return self::createTabEntry(__('Remote management', 'fusioninventory'), $nb);
            }
         }
      }
      return array();
   }



   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      $pfComputerRemoteManagement = new PluginFusioninventoryComputerRemoteManagement();
      if (get_class($item) == 'Computer') {
         $pfComputerRemoteManagement->showForm($item->getID());
      }
      return TRUE;
   }



   function showForm($computers_id) {

      $pfRemoteManagement = new self();
      $a_remotemanagement = $pfRemoteManagement->find("`computers_id`='".$computers_id."'");

      if (count($a_remotemanagement)) {

         echo '<div align="center">';
         echo '<table class="tab_cadre_fixe" style="margin: 5px 0 0;">';
         echo '<tr>';
         echo '<th colspan="4">'.__('Remote management', 'fusioninventory').'</th>';
         echo '</tr>';

         foreach ($a_remotemanagement as $remotemanagement) {
            echo "<tr class='tab_bg_1'>";
            echo "<td>".__('Type')."&nbsp;:</td>";
            echo "<td>".$remotemanagement['type']."</td>";
            echo "<td>".__('ID', 'fusioninventory')."&nbsp;:</td>";
            echo "<td>".$remotemanagement['number']."</td>";
            echo "</tr>";
         }
         echo '</table>';
         echo '</div>';
      }
   }



   static function cleanComputer($computers_id) {
      $pfComputerRemoteManagement = new PluginFusioninventoryComputerRemoteManagement();
      $a_remotemgmts = $pfComputerRemoteManagement->find("`computers_id`='".$computers_id."'");
      foreach ($a_remotemgmts as $data) {
         $pfComputerRemoteManagement->delete($data);
      }
   }
}

?>