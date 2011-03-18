<?php

  /**
   * sfPropertiesIniFile
   * handle project properties.ini file
   * 
   */
class sfPropertiesIniFile
{
    static $prop = null;
    static function getIniFilePath(){
        return SF_ROOT_DIR.DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."properties.ini";
    }
    /**
     *
     * #test ::get(var,ns)
     * <code>
     * #ok(sfPropertiesIniFile::get("symfony"),"has symfony section");
     * #ok(sfPropertiesIniFile::get("symfony","author"),"has symfony/author");
     * </code>
     */
    static function get($sec,$var=null){
        if(!self::$prop){
            self::$prop  = parse_ini_file(self::getIniFilePath(),true);
        }
        if(is_null($var)){
            return self::$prop[$sec];
        }
        return self::$prop[$sec][$var];
    }

}
