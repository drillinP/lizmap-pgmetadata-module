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
        $.getJSON(
            url,
            options,
            function( data, status, xhr ) {
                if (data){
                    if (data.status == 'error') {
                        console.log(data.message);
                    } else {
                        set_metadata_in_subdock(data.html);
                    }
                }
            }
        );
    }

    function hideFunction() {
        var x = document.getElementById("pgmetadata-content");
        if (x.style.display === "none") {
          x.style.display = "block";
        } else {
          x.style.display = "none";
        }
    }

    function set_metadata_in_subdock(html) {
        if (html) {
            console.log('html has content: need to fill in subdock Metadata content with HTML');
            // Add html content in div
            html = '<div id="pgmetadata-content">'+ html +'</div>';

            // Get subdock
            var subdock = $('.sub-metadata');
            content = subdock.find('div[class="menu-content"]');

            // create button
            var btn = $('<button onClick="hideFunction()">Fiche détails</button>');
            btn.addClass("btn btn-mini pgmetadata-button");

            // Add button and html to subdock
            content.append(btn);
            content.append(html);

            // get and hide content
            var x = document.getElementById("pgmetadata-content");
            x.style.display = "none";

            // adding showing / hiding on click
            btn.click(function(){
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            });
        } else {
            console.log('html is null: need to erase subdock Metadata content');
        }
    }

    return {};
}();
