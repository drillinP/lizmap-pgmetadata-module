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
    $rep = $this->getResponse('json');
    $result = Null;
    $filterParams = array();

    // vérifier que les paramètres repository, project, geom, srid sont non null ou vide

    $project = $this->param('project');
    $repository = $this->param('repository');
    $layername = $this->param('layername');

    if(!$project){
      $rep->data = array('status'=>'error', 'message'=>'Project not find');
      return $rep;
    }

    if(!$repository){
      $rep->data = array('status'=>'error', 'message'=>'Repository not find');
      return $rep;
    }

    if(!$layername){
      $rep->data = array('status'=>'error', 'message'=>'Layer name not find');
      return $rep;
    }

    $p = lizmap::getProject($repository.'~'.$project);
    if( !$p ){
        $rep->data = array('status'=>'error', 'message'=>'A problem occured while loading project with Lizmap');
        return $rep;
    }

    if (!$p->checkAcl()) {
      $rep->data = array('status'=>'error', 'message'=>jLocale::get('view~default.repository.access.denied'));

      return $rep;
    }

    $l = $p->findLayerByName($layername);
    if(!$l){
      $rep->data = array('status'=>'error', 'message'=>'Layer '.$layername.' does not exist');
      return $rep;
    }
    $layer = $p->getLayer($l->id);
    if(!$layer->getProvider() == 'postgres'){
      $rep->data = array('status'=>'error', 'message'=>'Layer '.$layername.' is not a postgreSQl layer');
      return $rep;
    }
    $layerParameters = $layer->getDatasourceParameters();
    $schema = $layerParameters->schema;
    $tablename = $layerParameters->tablename;

    $filterParams[] = $schema;
    $filterParams[] = $tablename;

    $profile = pgmetadataProfile::get($repository, $project, $tablename);

    $autocomplete = jClasses::getService('pgmetadata~search');
    try {
        $result = $autocomplete->getData( $profile, array(), 'getDataset');
    } catch (Exception $e) {
      $rep->data = array('status'=>'error', 'message'=>'Layer dataset does not exist');
      return $rep;
    }

    try {
      $result = $autocomplete->getData( $profile, $filterParams, 'getHtml');
    } catch (Exception $e) {
      $rep->data = array('status'=>'error', 'message'=>'Impossible to generate the Html to '.$layername);
      return $rep;
    }

    $rep->data = $result->fetchAll();
    return $rep;

  }

}
