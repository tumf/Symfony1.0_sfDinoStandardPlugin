<?php
  /**
   * This is a Symfony plugin. Thanks to Symfony Project.
   * 
   * (c) 2007 Dino Co.,Ltd.
   *
   * For the full copyright and license information, please view the LICENSE
   * file that was distributed with this source code.
   * 
   * @author     TAKAHARA Yoshihiro <y.takahara at gmail dot com>
   * @version    SVN: $Id: sfHydrateRequestParameters.class.php 60 2007-01-23 03:59:15Z tumf $
   *
   * . in Action
   * $this->hydrateObject($object,array('param1','param2',...));
   * $params
   *   = array(
   *    "param1", 
   *    "param2" => "Param2",
   *    "param3" => array("method"=>"Param3,"default"=>3),
   *    "param4" => array("default"=>3))
   *
   */
class sfHydrateRequestParameters
{
    public function hydrateObject($component,&$object,$params = array() )
    {

        foreach($params as $key => $val){
            $default = null;
            if(is_numeric($key)){
                //    "param1",
                $param = $val;
                $method = "Set".sfInflector::classify($param);
            }else{
                $param = $key;
                if(is_array($val)){
                    if(array_key_exists("method",$val)){
                        //    "param3" => array("method"=>"Param3,"default"=>3),
                        $method = "Set".$val["method"];
                    }else{
                        //    "param4" => array("default"=>3))
                        $method = "Set".sfInflector::classify($param);
                    }
                    if(array_key_exists("default",$val)){
                        $default = $val["default"];
                    }

                }else{
                    //    "param2" => "Param2",
                    $method = "Set".$val;
                }
            }
            if($v = $component->getRequestParameter($param,$default)){
                call_user_func_array(array($object,$method),array($v));
            }
        }
    }

    public function hydrateArray($component,&$array,$params = array() )
    {
        foreach($params as $key => $val){
            $default = null;
            if(is_numeric($key)){
                //    "param1",
                $param = $val;
                $to = $val;
            }else{
                $param = $key;
                if(is_array($val)){
                    if(array_key_exists("to",$val)){
                        //    "param3" => array("method"=>"Param3,"default"=>3),
                        $to = $val["to"];
                    }else{
                        //    "param4" => array("default"=>3))
                        $to = $param;
                    }
                    if(array_key_exists("default",$val)){
                        $default = $val["default"];
                    }

                }else{
                    //    "param2" => "Param2",
                    $to = $val;
                }
            }
            $array[$to] = $component->getRequestParameter($param,$default);
        }
        return $array;
    }
}

sfMixer::register('sfComponent', array('sfHydrateRequestParameters', 'hydrateObject'));
sfMixer::register('sfComponent', array('sfHydrateRequestParameters', 'hydrateArray'));
