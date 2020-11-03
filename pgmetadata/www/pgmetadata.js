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
    }
  });
  return {};
}();
