<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Script file of Bible Plan mod
 */
class mod_bibleplanInstallerScript
{
    var $status;
    /**
     * method to install the module
     *
     * @return void
     */
    function install($parent) {
        $db = JFactory::getDBO();

        //create the tables
        $query = 'CREATE TABLE #__bible_plans (
              id varchar(255),
              `name` varchar(255),
              info varchar(255),
              version varchar(50),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8;';
        $db->setQuery($query);
        if (!$db->execute()) {
            echo "<p style='color: red;'>" . $db->stderr(true) . "</p>";
        } else {
            $query = 'CREATE TABLE #__bible_data (
                  bibleplan varchar(255),
                  day int(11),
                  verses text,
                  UNIQUE `plan` (bibleplan, day)
                ) DEFAULT CHARACTER SET utf8;';
            $db->setQuery($query);
            if (!$db->execute()) {
                echo "<p style='color: red;'>" . $db->stderr(true) . "</p>";
            } else {
                $this->status = true;
            }
        }
    }

    /**
     * method to uninstall the module
     *
     * @return void
     */
    function uninstall($parent) {
        $db = JFactory::getDBO();
        $db->dropTable('#__bible_plans');
        $db->dropTable('#__bible_data');

        // $parent is the class calling this method
        echo '<p>The Bible Plan module and all associated database tables have been uninstalled.</p>';
    }

    /**
     * method to update the module
     *
     * @return void
     */
    function update($parent) {
        //find out if tables exists
        $db           = JFactory::getDBO();
        $table_list   = $db->getTableList();
        $table_prefix = $db->getPrefix();
        //create the IPN report table if it does not exist already
        if (array_search($table_prefix . 'bible_plans', $table_list) == false) {
            $this->install($parent);
        }
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {
        JFactory::getLanguage()->load('mod_bibleplan', JPATH_SITE);
        $type = strtolower($type);
        if ($type != 'uninstall') {
            include_once JPATH_SITE . DS . "modules" . DS . "mod_bibleplan" . DS . "helper.php";
            include_once JPATH_SITE . DS . "modules" . DS . "mod_bibleplan" . DS . "includes" . DS . "abstract.readingplan.php";
        }

        switch ($type) {
            case "install":
                if (!empty($this->status)) {
                    JFactory::getLanguage()->load("mod_bibleplan", JPATH_SITE);

                    jimport('joomla.filesystem.folder');
                    $available_plans = JFolder::files(JPATH_SITE . DS . 'modules' . DS . 'mod_bibleplan' . DS . 'readingplans', '.', false, false, array('index.html'));

                    if (empty($available_plans)) {
                        echo "<p style='color: red;'>" . JText::_('MOD_BIBLEPLAN_NO_PLANS_FOUND') . "</p>";
                        return false;
                    }

                    $error = false;
                    foreach ($available_plans as $plan) {
                        //remove .php from the filename
                        $plan_name = str_replace('.php', '', $plan);

                        //load the reading plan class
                        $rp =& biblePlanHelper::load_readingplan($plan_name);
                        if ($rp->install()) {
                            echo '<p style="color: green;">' . JText::sprintf('MOD_BIBLEPLAN_PLAN_INSTALL_SUCCESS', $rp->getName()) . '</p>';
                        } else  {
                            $error = true;
                            echo '<p style="color: red;">' . JText::sprintf('MOD_BIBLEPLAN_PLAN_INSTALL_FAILED', $rp->getName()) . '</p>';
                        }
                    }
                    if ($error) {
                        echo '<p>' . JText::_('MOD_BIBLEPLAN_INSTALLED_WITH_ERRORS') . '</p>';
                    } else {
                        echo '<p>' . JText::_('MOD_BIBLEPLAN_INSTALLED') . '</p>';
                    }
                }
                break;
            case 'update':
                jimport('joomla.filesystem.folder');
                $available_plans = JFolder::files(JPATH_SITE . DS . 'modules' . DS . 'mod_bibleplan' . DS . 'readingplans', '.', false, false, array('index.html'));

                if (empty($available_plans)) {
                    echo "<p style='color: red;'>" . JText::_('MOD_BIBLEPLAN_NO_PLANS_FOUND') . "</p>";
                    return false;
                }

                $db = JFactory::getDBO();

                $query = "SELECT * FROM #__bible_plans";
                $db->setQuery($query);
                $installed_plans = $db->loadObjectList('id');

                foreach ($available_plans as $plan) {
                    //remove .php from the filename
                    $plan_name = str_replace('.php', '', $plan);

                    //load the reading plan class
                    $rp = biblePlanHelper::load_readingplan($plan_name);

                    if (!array_key_exists($plan_name, $installed_plans)) {
                        if ($rp->install()) {
                            echo '<p style="color: green;">' . JText::sprintf('MOD_BIBLEPLAN_PLAN_INSTALL_SUCCESS', $rp->getName()) . '</p>';
                        } else  {
                            echo '<p style="color: red;">' . JText::sprintf('MOD_BIBLEPLAN_PLAN_INSTALL_FAILED', $rp->getName()) . '</p>';
                        }
                    } else {
                        //check for an update
                        if (version_compare($installed_plans[$plan_name]->version,  $rp->getVersion(), '<')) {
                            if ($rp->upgrade($plan->version)) {
                                echo '<p style="color: green;">' . JText::sprintf('MOD_BIBLEPLAN_PLAN_UPGRADE_SUCCESS', $rp->getName()) . '</p>';
                            } else  {
                                echo '<p style="color: red;">' . JText::sprintf('MOD_BIBLEPLAN_PLAN_UPGRADE_FAILED', $rp->getName()) . '</p>';
                            }
                        }
                    }

                    //remove the installed plan so that we know if we no longer have a file for an installed plan
                    unset($installed_plans[$plan_name]);
                }

                if (!empty($installed_plans)) {
                    //seems we are now missing the plans file so uninstall from the DB
                    foreach ($installed_plans as $plan) {
                        $q = $db->getQuery(true);
                        $q->delete("#__bible_data")->where("bibleplan = " . $db->q($plan->id));
                        $db->setQuery($q);
                        $db->execute();
                        $q->delete("#__bible_plans")->where("id = " . $db->q($plan->id));
                        $db->setQuery($q);
                        $db->execute();
                        echo "<p>" . JText::sprintf("MOD_BIBLEPLAN_NO_LONGER_AVAILABLE", $plan->name) . "</p>";
                    }
                }

                // $parent is the class calling this method
                echo '<p>' . JText::sprintf('MOD_BIBLEPLAN_UPDATED', $parent->get('manifest')->version) . '</p>';
                break;
            case 'uninstall':
                break;
            default;
                echo "<p style='color: red;'>Error: $type</p>";
                break;
        }
    }
}