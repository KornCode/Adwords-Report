(function (global) {
    // check point
    var options = window.kodsana_options;

    var str = Object.keys(options).map(function(key) {
        return key + '=' + options[key];
    }).join('&');

    // Send post request
    let http = new XMLHttpRequest();
    let server_url = "http://localhost:8000";
    let url = server_url + '/get_components';
    let params = str;
    http.open('POST', url, true);

    // Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Call a function when the state changes.
    http.onreadystatechange = function() { 

        if (http.readyState == 4 && http.status == 200) {
            let response = JSON.parse(http.responseText);
            let components = response.components;
            let option = response.components;
            let domain = response.domain;
            let align = response.align;

            font_awe = document.createElement('link');
            font_awe.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css';
            font_awe.rel = 'stylesheet'; 
            font_awe.type = 'text/css';

            if (align == "mobile") {
                // Create Floating Action Buttons container
                link = document.createElement('link');
                link.href = server_url + '/css/embed_style_h.css';
                link.rel = 'stylesheet';
                link.type = 'text/css';
                link.media = 'all';

                // Widget Init
                var widget_container;
                var container, button_nav, buttons = [];
                var widget_container = document.getElementById('load_widget');

                container = document.createElement('div');
                button_nav = document.createElement('div');
                button_nav.setAttribute('class', 'button_nav');

                for (var i = 0; i < components.length; i++) {
                    var icon = document.createElement('i');

                    // icon type and icon size
                    icon.setAttribute('class', option[i].options.icon + ' fa-3x');

                    // icon color
                    icon.style.color = option[i].options.backgroundColor;

                    buttons[i] = document.createElement('a');
                    buttons[i].setAttribute('class', 'buttons');

                    // icon tooltip hover name
                    // buttons[i].setAttribute('tooltip', components[i].name);
                    buttons[i].href = domain;
                    buttons[i].target = '_blank';

                    buttons[i].appendChild(icon);
                    button_nav.appendChild(buttons[i])
                }

                // Append to parent container
                container.appendChild(button_nav);
            }
            else if (align == "desktop") {
                // Create Floating Action Buttons container
                link = document.createElement('link');
                link.href = server_url + '/css/embed_style_v.css';
                link.rel = 'stylesheet';
                link.type = 'text/css';
                link.media = 'all';

                // Widget Init
                var widget_container;
                var container, nav, buttons = [], button_main, span_button_main, sub_span_button_main;
                var widget_container = document.getElementById('load_widget');

                container = document.createElement('div');
                nav = document.createElement('nav');
                nav.setAttribute('class', 'container');

                for (var i = 0; i < components.length; i++) {
                    var icon = document.createElement('i');

                    // icon type and icon size
                    icon.setAttribute('class', option[i].options.icon);
                    icon.style.fontSize = option[i].options.size;

                    // icon color
                    icon.style.color = option[i].options.backgroundColor;
            
                    buttons[i] = document.createElement('a');
                    buttons[i].setAttribute('class', 'buttons');
                    buttons[i].setAttribute('id', 'test');

                    // icon tooltip hover name
                    buttons[i].setAttribute('tooltip', components[i].name);
                    console.log(components[i].name);
                    buttons[i].style.color = option[i].options.textColor;
                    // buttons[i].style.background = option[i].options.textBackgroundColor;
                    buttons[i].style.background = '#D5DBDB';
                    buttons[i].href = domain;
                    buttons[i].target = '_blank';
            
                    buttons[i].appendChild(icon);
                    nav.appendChild(buttons[i]);
                }
            
                button_main = document.createElement('a');
                button_main.setAttribute('class', 'buttons');
                button_main.setAttribute('tooltip', 'Compose');
                button_main.style.color = '#F8F9F9';
            
                span_button_main = document.createElement('span');
                sub_span_button_main = document.createElement('span');
                sub_span_button_main.setAttribute('class', 'rotate');
            
                // Append to parent container
                span_button_main.appendChild(sub_span_button_main);
                button_main.appendChild(span_button_main);
                nav.appendChild(button_main);
                container.appendChild(nav);
            }

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

function isMobileDevice() {
    return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
};






