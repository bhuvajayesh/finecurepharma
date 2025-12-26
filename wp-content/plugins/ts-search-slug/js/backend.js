jQuery(document).ready(function() {
    function ts_search_slug_update_list() {
        // Daten, die gesendet werden sollen
        var data = {
            action: 'tsinf_get_state_list',
            security: TS_Search_Slug_JS_Obj.nonce,
        };

        // AJAX-Post-Request
        jQuery.post(TS_Search_Slug_JS_Obj.ajax_url, data, function(response) {

            try {
                let markup = '<ul>';

                jQuery.each(response.pages_with_states, function(index, item) {

                    markup += '<li>';

                    jQuery.each(item.states, function(index_state, state) {
                        markup += '<strong>' + state + '</strong>' + ' ';
                    });

                    markup += '<br />' + item.title + ' (ID: ' + index + ')<br /><a href="' + item.backend_link + '">Backend</a> - <a href="' + item.link + '" target="_blank">Frondend</a></li>';

                });

                markup += '</ul>';

                jQuery("#ts-search-slug-page-state-menu .ts-search-slug-page-state-menu-inner").html(markup);


            } catch(e) {
                console.log(e);
            }

        }).fail(function(xhr, status, error) {
            console.error('Fehler:', error);
        });
    }

    jQuery("#ts-search-slug-open-state-list").on("click touchend", function(e) {
        e.preventDefault();
        e.stopPropagation();

        let menu = jQuery("#ts-search-slug-page-state-menu");
        if(menu !== undefined && menu !== null && menu.length > 0) {

            menu.show();

            ts_search_slug_update_list();
        }

    });

    jQuery("#ts-search-slug-page-state-menu-close-button").on("click touchend", function(e) {
        e.preventDefault();
        e.stopPropagation();

        let close_button = jQuery(this);
        let menu = close_button.closest("#ts-search-slug-page-state-menu");

        if(menu !== undefined && menu !== null && menu.length > 0) {

            menu.hide();

        }

    });

});

