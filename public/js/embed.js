(function (global) {
    var options = window.kodsana_options;

    var str = Object.keys(options).map(function(key) {
        return key + '=' + options[key];
    }).join('&');

    var widget_response;
    // Send post request
    var http = new XMLHttpRequest();
    var server_url = "http://localhost:8000";
    var url = server_url + '/get_components';
    var params = str;
    http.open('POST', url, true);

    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() { //Call a function when the state changes.
        if(http.readyState == 4 && http.status == 200) {
            var response = JSON.parse(http.responseText);
            var components = response.components;
            var domain = response.domain;
            var fas_icon = response.components;

            // Widget Init
            var widget_container;
            
            var container, nav, button_main, span_button_main, sub_span_button_main;

            var widget_container = document.getElementById('load_widget');

            // Create Floating Action Buttons container
            link = document.createElement('link');
            link.href = server_url + '/css/embed_style.css';
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.media = 'all';

            font_awe = document.createElement('link');
            font_awe.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css';
            font_awe.rel = 'stylesheet';
            font_awe.type = 'text/css';

            container = document.createElement('div');
            nav = document.createElement('nav');
            nav.setAttribute('class', 'container');

            var buttons = [];
            for (var i = 0; i < components.length; i++) {
                var icon = document.createElement('i');
                icon.setAttribute('class', fas_icon[i].options.icon + ' fa-2x');
                icon.style.position = 'relative';
                icon.style.left = '15%';
                icon.style.top = '15%';

                var title = components[i].name;
                buttons[i] = document.createElement('a');
                buttons[i].setAttribute('class', 'buttons');
                buttons[i].setAttribute('tooltip', title);
                buttons[i].href = domain;
                // buttons[i].target = '_blank';

                buttons[i].appendChild(icon);
                nav.appendChild(buttons[i]);
            }

            button_main = document.createElement('a');
            button_main.setAttribute('class', 'buttons');
            button_main.setAttribute('tooltip', 'Compose');

            span_button_main = document.createElement('span');

            sub_span_button_main = document.createElement('span');
            sub_span_button_main.setAttribute('class', 'rotate');

            // Append to parent container
            span_button_main.appendChild(sub_span_button_main);
            button_main.appendChild(span_button_main);
            nav.appendChild(button_main);
            container.appendChild(nav);
            container.appendChild(link);
            container.appendChild(font_awe);

            widget_container.style.margin = '1em';
            widget_container.style.position = 'fixed';
            widget_container.style.bottom = '0';
            widget_container.style.right = '0';

            widget_container.parentNode.replaceChild(container, widget_container);
        }
    }
    http.send(params);

} (this) );





