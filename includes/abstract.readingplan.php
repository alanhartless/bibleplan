<?php

// No direct access
defined('_JEXEC') or die('Restricted access');

class bibleplan {
    /**
     * Returns the version of the reading plan in 1.0.0 format
     * @return string
     */
    function getVersion() {
        return '0.0,0';
    }

    /**
     * Returns the unique ID for this reading plan in all lowercase and with alphanumeric characters only
     * @return string
     */
    function getId() {
        return "";
    }

    /**
     * Returns the human readable name of the reading plan
     * @return string
     */
    function getName() {
        return "";
    }

    /**
     * Returns info on the reading plan such as copyright
     * @return string
     */
    function getInfo() {
        return "";
    }

    /**
     * Return array in array( $day => $verse, $day2 => $verse2, ... ) format
     * @return array
     */
    function getData() {
        return array();
    }

    /**
     * Called by module's script file to install reading plan
     * @return bool
     */
    function install() {
        $data = $this->getData();

        if (empty($data)) {
            return false;
        }

        $db =& JFactory::getDBO();
        $q  = $db->getQuery(true);

        $q->insert("#__bible_plans")
            ->set("id = " . $db->q($this->getId()))
            ->set("name = " . $db->q($this->getName()))
            ->set("info = " . $db->q($this->getInfo()))
            ->set("version = " . $db->q($this->getVersion()));
        $db->setQuery($q);
        if (!$db->execute()) {
            echo "<p style='color: red;'>" . $db->stderr() . "</p>";
            return false;
        } else {
            $q  = $db->getQuery(true);
            $q->insert("#__bible_data")
                ->columns(array("bibleplan", "day", "verses"));
            foreach ($data as $day => $verses) {
                $q->values($db->q($this->getId()) . ", " . $db->q($day) . ", " . $db->q($verses));
            }
            $db->setQuery($q);
            if (!$db->execute()) {
                echo "<p style='color: red;'>" . $db->stderr() . "</p>";
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Called by module's script file to upgrade the reading plan
     * Only called if the $this->getVersion() is newer than $current_version
     * @param $current_version  Version currently installed
     * @return bool
     */
    function upgrade($current_version) {
        $data = $this->getData();

        if (empty($data)) {
            return false;
        }

        $db =& JFactory::getDBO();
        $q  = $db->getQuery(true);

        $q->update("#__bible_plans")
            ->set("name = " . $db->q($this->getName()))
            ->set("info = " . $db->q($this->getInfo()))
            ->set("version = " . $db->q($this->getVersion()))
            ->where("id = " . $db->q($this->getId()));
        $db->setQuery($q);
        if (!$db->execute()) {
            echo "<p style='color: red;'>" . $db->stderr() . "</p>";
            return false;
        } else {
            $q      = "REPLACE INTO #__bible_data (bibleplan, day, verses) VALUES ";
            $values = array();
            foreach ($data as $day => $verses) {
                $values[] = "(" . $db->q($this->getId()) . ", " . $db->q($day) . ", " . $db->q($verses) . ")";
            }
            $q .= implode(", ", $values);
            $db->setQuery($q);
            if (!$db->execute()) {
                echo "<p style='color: red;'>" . $db->stderr() . "</p>";
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Called by this class to uninstall the reading plan
     * @return bool
     */
    function uninstall() {
        $db =& JFactory::getDbo();
        $q  = $db->getQuery(true);
        $q->delete("#__bible_data")->where("bibleplan = " . $db->q($this->getId()));
        $db->setQuery($q);
        if (!$q->execute()) {
            echo "<p style='color: red;'>" . $db->stderr() . "</p>";
            return false;
        } else {
            $q->delete("#__bible_plans")->where("id = " . $db->q($this->getId()));
            $db->setQuery($q);
            if (!$q->execute()) {
                echo "<p style='color: red;'>" . $db->stderr() . "</p>";
                return false;
            } else {
                return true;
            }
        }
    }
}
?>