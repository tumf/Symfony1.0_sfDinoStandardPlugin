<?php
/**
 *
 *
 *
 */
class dfSessionStorage extends sfSessionStorage
{
  public function initialize($context, $parameters = null)
  {
    $sessionName = "symfony";
    if(isset($parameters['session_name'])){
      $sessionName = $parameters['session_name'];
    }
    if($context->getRequest()->isSecure()){
      $sessionName = $sessionName. "_ssl";
      $parameters['session_cookie_secure'] = true;
    }else{
      $parameters['session_cookie_secure'] = false;
    }
    $parameters['session_name'] = $sessionName;

    // initialize parent
    parent::initialize($context, $parameters);
  }  
}  
