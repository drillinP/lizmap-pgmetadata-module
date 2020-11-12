/**
* @package   lizmap
* @subpackage pgmetadata
* @author    Pierre DRILLIN
* @copyright 2020 3liz
* @link      https://3liz.com
* @license    Mozilla Public Licence
*/
(function() {
    lizMap.events.on({
        'lizmapswitcheritemselected': function(evt){
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
        if (html) {
            // Build metadata panel opener
            let opener = '<details class="pg-metadata"> <summary> ';
            opener+= pgmetadataLocales['ui.button.pgmetadataHtml'];
            opener+= ' </summary>  </details>';

            // Add metadata opener
            document.querySelector('#sub-dock .menu-content').insertAdjacentHTML('beforeend', opener);

            // Add metadata content
            document.querySelector('#sub-dock .sub-metadata .pg-metadata').insertAdjacentHTML('beforeend', html);
        }
    }
    return {};
})();
