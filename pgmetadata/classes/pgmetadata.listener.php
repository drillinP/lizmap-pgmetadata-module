<?php
/**
* @package   lizmap
* @subpackage pgmetadata
* @author    Pierre DRILLIN
* @copyright 2020 3liz
* @link      https://3liz.com
* @license    Mozilla Public Licence
*/

class pgmetadataListener extends jEventListener{

   function ongetMapAdditions ($event) {

        // vérifier que le repository et le project correspondent à un projet lizmap
        $repository = $event->repository;
        $project = $event->project;
        $p = lizmap::getProject($repository.'~'.$project);
        if( !$p ){
             return;
        }

        if(!jAcl2::check('lizmap.tools.edition.use', $repository)) {
          return;
        }

        // vérifier que le projet contient la couche nomdecouche

        $l = $p->findLayerByName('nomdecouche');
        if(!$l){
          return;
        }

        $layer = $p->getLayer($l->id);
        if (!$layer->isEditable()){
          return;
        }

        $dLayer = $layer->getEditionCapabilities();

       // Check if user groups intersects groups allowed by project editor
       // If user is admin, no need to check for given groups
       if (jAuth::isConnected() and !jAcl2::check('lizmap.admin.repositories.delete') and property_exists($dLayer, 'acl') and $eLayer->acl) {
            // Check if configured groups white list and authenticated user groups list intersects
            $editionGroups = $dLayer->acl;
            $editionGroups = array_map('trim', explode(',', $editionGroups));
            if (is_array($editionGroups) and count($editionGroups) > 0) {
                $userGroups = jAcl2DbUserGroup::getGroups();
                if (!array_intersect($editionGroups, $userGroups)) {
                    return;
                }
            }
        }

       $juser = jAuth::getUserSession();
       if(!$juser){
         $user_login = '';
       }else{
         $user_login = $juser->login;
       }

       $js = array();
       $jscode = array();
       $css = array();

       $pgmetadataConfig = array();

       $pgmetadataConfig['user'] = $user_login;

       $pgmetadataConfig['nomdedecouche'] = array();
       $pgmetadataConfig['nomdedecouche']['id'] = $layer->getId();
       $pgmetadataConfig['nomdedecouche']['name'] = $layer->getName();

       $pgmetadataConfig['urls'] = array();
       $pgmetadataConfig['urls']['select'] = jUrl::get('pgmetadata~service:select');
       $pgmetadataConfig['urls']['update'] = jUrl::get('pgmetadata~service:update');
       $pgmetadataConfig['urls']['export'] = jUrl::get('pgmetadata~service:export');

       $bp = jApp::config()->urlengine['basePath'];

       $js = array();
       $js[] = jUrl::get('jelix~www:getfile', array('targetmodule'=>'pgmetadata', 'file'=>'pgmetadata.js'));

       $jscode = array(
                'var pgmetadataConfig = ' . json_encode($pgmetadataConfig)
       );

       $event->add(
           array(
               'js' => $js,
               'jscode' => $jscode
           )
       );
   }
}
?>
