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
            let length = components.length;

            font_awe = document.createElement('link');
            font_awe.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css';
            font_awe.rel = 'stylesheet'; 
            font_awe.type = 'text/css';

            var extraSize = 0;
            var extraMargin = 0;
            if (isMobileDevice()) {
                console.log('mobile');
                if (screen.width >= 768 && screen.height <= 1024) {
                    extraSize = 35;
                    extraMargin = 8;
                } 
                else if (screen.width >= 1024) {
                    extraSize = 55;
                    extraMargin = 20;
                }
            }

            if (align == "mobile") {
                // Create Floating Action Buttons container
                link = document.createElement('link');
                link.href = server_url + '/css/embed_style_h.css';
                link.rel = 'stylesheet';
                link.type = 'text/css';
                link.media = 'all';

                // Widget Init
                var widget_container;
                var container, nav, button = [];
                var widget_container = document.getElementById('load_widget');

                container = document.createElement('div');

                nav = document.createElement('div');
                nav.setAttribute('class', 'nav');

                for (var i = 0; i < length; i++) {
                    var icon = document.createElement('i');

                    var iconSize = parseInt(option[i].options.size) + extraSize + 'px';
                    var backgroundSize = parseInt(option[i].options.size) + 14 + extraSize + 'px';
 
                    // icon size and color
                    icon.setAttribute('class', option[i].options.icon + ' icon_properties');
                    icon.style.fontSize = iconSize;
                    icon.style.color = option[i].options.iconColor;

                    // icon background color
                    button[i] = document.createElement('a');
                    button[i].setAttribute('class', 'background_properties');
                    button[i].style.height = backgroundSize ;
                    button[i].style.width = backgroundSize;
                    button[i].style.background = option[i].options.backgroundColor;
                    button[i].style.marginRight = 15 + extraMargin + 'px';

                    button[i].href = domain;
                    button[i].target = '_blank';

                    button[i].appendChild(icon);
                    nav.appendChild(button[i])
                }

                // Append to parent container
                container.appendChild(nav);
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

                for (var i = 0; i < length; i++) {
                    var icon = document.createElement('i');
                    var iconSize = parseInt(option[i].options.size) + 'px';
                    var backgroundSize = parseInt(option[i].options.size) + 14 + 'px';

                    // icon size and color
                    icon.setAttribute('class', option[i].options.icon + ' icon_properties');
                    icon.style.fontSize = iconSize;
                    icon.style.color = option[i].options.iconColor;

                    buttons[i] = document.createElement('a');
                    buttons[i].setAttribute('class', 'buttons');

                    // icon tooltip name
                    buttons[i].setAttribute('tooltip', components[i].name);
                    buttons[i].style.color = option[i].options.tooltipColor;

                    // icon background color
                    buttons[i].style.background = option[i].options.backgroundColor;
                    buttons[i].style.width = backgroundSize;
                    buttons[i].style.height = backgroundSize;

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

            widget_container.parentNode.replaceChild(container, widget_container);
        }
    }
    http.send(params);

} (this) );

function isMobileDevice() {
    return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
};






