/**
* @package   lizmap
* @subpackage pgmetadata
* @author    Pierre DRILLIN
* @copyright 2020 3liz
* @link      https://3liz.com
* @license    Mozilla Public Licence
*/

var lizPgmetadata = function() {
    lizMap.events.on({
        'lizmapswitcheritemselected': function(evt){
            console.log(pgmetadataLocales['ui.button.pgmetadataHtml'] );
            if (evt.selected) {
                var layername = lizMap.getLayerNameByCleanName(evt.name);
                get_metadata_html(layername);
            }
        }
    });

    function get_metadata_html(layername) {
        var options = {
            repository: lizUrls.params.repository,
            project: lizUrls.params.project,
            layername: layername
        };
        var url = pgmetadataConfig['urls']['index'];
        url = url + '?' + new URLSearchParams(options);
        fetch(url).then(function(response) {
            return response.json();
        }).then(function(formdata) {
            if (formdata){
                if (formdata.status == 'error') {
                    console.log(formdata.message);
                } else {
                    set_metadata_in_subdock(formdata.html);
                }
            }
        });
    }

    function set_metadata_in_subdock(html){
        if(html){
            console.log('html has content: need to fill in subdock Metadata content with HTML');
            // Add html content in div
            html = '<div id="pgmetadata-content">'+ html +'</div>';

            // Get subdock
            document.querySelector('#sub-dock .menu-content').insertAdjacentHTML('beforeend', '<details class="pg-metadata"> <summary> '+ pgmetadataLocales['ui.button.pgmetadataHtml'] +' </summary>  </details>');

            document.querySelector('#sub-dock .menu-content .pg-metadata').insertAdjacentHTML('beforeend', html);
        } else {
            console.log('html is null: need to erase subdock Metadata content');
        }
    }    
    return {};
}();
