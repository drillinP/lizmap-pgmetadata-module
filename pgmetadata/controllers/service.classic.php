<?php
/**
* @package   lizmap
* @subpackage pgmetadata
* @author    Pierre DRILLIN
* @copyright 2020 3liz
* @link      https://3liz.com
* @license    All rights reserved
*/

class serviceCtrl extends jController {

  function index(){
      $rep = $this->getResponse('html');
      $rep->addContent('<p>Test</p>');
      return $rep;
  }

}
