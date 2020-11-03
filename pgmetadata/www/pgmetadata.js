/**
* @package   lizmap
* @subpackage pgmetadata
* @author    Pierre DRILLIN
* @copyright 2020 3liz
* @link      https://3liz.com
* @license    Mozilla Public Licence
*/

var lizPgmetadata = function() {
  console.log('PGMETADATA');
  lizMap.events.on({
    'lizmapswitcheritemselected': function(evt){
      console.log(evt);
      var options = {
        repository: lizUrls.params.repository,
        project: lizUrls.params.project,
        layername: ''+evt.name
      };
      var url = pgmetadataConfig['urls']['index'];
         $.getJSON(
             url,
             options,
             function( data, status, xhr ) {
                 if(data){
                     console.log(data);
                 }
             }
         );
        }
  });
  return {};
}();
