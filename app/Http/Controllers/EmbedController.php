<?php
// check point
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\UserMeta;

use Illuminate\Http\Request;
use App\Widget;
use App\Component;
use App\WidgetComponent;
use Storage;

class EmbedController extends Controller
{
    public function testFunction(Request $request){
        $widget_id = $request->filled('widget_id') ? $request->get('widget_id') : false;
        $widget = Widget::with('components')->find($widget_id);

        foreach($widget->components as $component) {
            $custom_options = WidgetComponent::where('widget_id', $widget_id)->where('component_id', $component->id)->first();
            $component->options = serialize(array_merge((array) $component->options, (array) $custom_options->options));
        }

        return response($widget, 200);
    }

    private function minify_js($input) {
        if(trim($input) === "") return $input;
        return preg_replace(
            array(
                // Remove comment(s)
                '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                // Remove white-space(s) outside the string and regex
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                // Remove the last semicolon
                '#;+\}#',
                // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
                // --ibid. From `foo['bar']` to `foo.bar`
                '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
            ),
            array(
                '$1',
                '$1$2',
                '}',
                '$1$3',
                '$1.$3'
            ),
        $input);
    }

    private function minify_css($input) {
        if(trim($input) === "") return $input;
        return preg_replace(
            array(
                // Remove comment(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                // Remove unused white-space(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                // Replace `:0 0 0 0` with `:0`
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                // Replace `background-position:0` with `background-position:0 0`
                '#(background-position):0(?=[;\}])#si',
                // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
                '#(?<=[\s:,\-])0+\.(\d+)#s',
                // Minify string value
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                // Minify HEX color code
                '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                // Replace `(border|outline):none` with `(border|outline):0`
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                // Remove empty selector(s)
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
            ),
            array(
                '$1',
                '$1$2$3$4$5$6$7',
                '$1',
                ':0',
                '$1:0 0',
                '.$1',
                '$1$3',
                '$1$2$4$5',
                '$1$2$3',
                '$1:0',
                '$1$2'
            ),
        $input);
    }

    /**
     * Send Embed
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmbedCode() {
        $widget_comp = WidgetComponent::find(19);
        $widget = Widget::find($widget_comp->widget_id);
        $component = Component::find($widget_comp->component_id);

        $w_tooltip = $widget->name;
        $w_domain = $widget->domain;

        $styleOptions = $component->options;
        $styleOptionsWC = $widget_comp->options;

        $styleOptions['icon'] = ($styleOptionsWC['icon'] != null) ? $styleOptionsWC['icon'] : $styleOptions['icon'];
        $styleOptions['backgroundColor'] = ($styleOptionsWC['backgroundColor'] != null) ? $styleOptionsWC['backgroundColor'] != null : $styleOptions['backgroundColor'];

        /*
		|--------------------------------------------------------------------------
		| JavaScript Management
		|--------------------------------------------------------------------------
		*/
        $js_code_slice1 = "(function (global) {
                                var widget_container;
                                var widget_container = document.getElementById('load_widget');";
        $js_code_slice2 = "var container, nav, button1, button_main, span_button_main, sub_span_button_main;";
        $js_code_slice3 = "link = document.createElement('link');
                            link.href = 'css/embed_style.css';
                            link.rel = 'stylesheet';
                            link.type = 'text/css';
                            link.media = 'all';";
        $js_code_slice4 = "container = document.createElement('div');
                            nav = document.createElement('nav');
                            nav.setAttribute('class', 'container');";
        
        $i = 4;
        foreach ($widget_comp as $wc) {
            $i++;
            ${"js_code_slice$i"} = "button1 = document.createElement('a');
                                    button1.setAttribute('class', 'buttons');
                                    button1.setAttribute('tooltip', '".$w_tooltip."');
                                    button1.href = '".$w_domain."';
                                    button1.style.backgroundColor = '".$styleOptions['backgroundColor']."';";
        }

        // $js_code_slice5 = "button1 = document.createElement('a');
        //                     button1.setAttribute('class', 'buttons');
        //                     button1.setAttribute('tooltip', '".$w_tooltip."');
        //                     button1.href = '".$w_domain."';
        //                     button1.style.backgroundColor = '".$styleOptions['backgroundColor']."';";
        
        $i = $i + 1;
        ${"js_code_slice$i"} = "button_main = document.createElement('a');
                            button_main.setAttribute('class', 'buttons');
                            button_main.setAttribute('tooltip', 'Compose');
                            button_main.href = '';
                            span_button_main = document.createElement('span');
                            sub_span_button_main = document.createElement('span');
                            sub_span_button_main.setAttribute('class', 'rotate');";
        $i = $i + 1;
        ${"js_code_slice$i"} = "span_button_main.appendChild(sub_span_button_main);
                            button_main.appendChild(span_button_main);
                            nav.appendChild(button1);
                            nav.appendChild(button_main);
                            container.appendChild(nav);
                            container.appendChild(link);";
        $i = $i + 1;
        ${"js_code_slice$i"} = "widget_container.style.margin = '1em';
                                widget_container.style.position = 'fixed';
                                widget_container.style.bottom = '0';
                                widget_container.style.right = '0';
                                widget_container.parentNode.replaceChild(container, widget_container);
                            } (this) );";
        
        
        $js_code = $this->minify_js($js_code_slice1.$js_code_slice2.$js_code_slice3.$js_code_slice4.
                                    $js_code_slice5.$js_code_slice6.$js_code_slice7.$js_code_slice8.
                                    $js_code_slice9.$js_code_slice10.$js_code_slice11);
        // $js_code = $js_code_slice1.$js_code_slice2.$js_code_slice3.$js_code_slice4.
        //             $js_code_slice5.$js_code_slice6.$js_code_slice7.$js_code_slice8;

        /*
		|--------------------------------------------------------------------------
		| CSS Management
		|--------------------------------------------------------------------------
        */
        $css_code_slice1 = "body {
                                background-color: #F2F2F2;
                                margin: 0;
                                max-height: 100vh; }
                            .header {
                                background: #4285f4;
                                width: 100%;
                                height: 56px;
                                box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28); }
                            .main {
                                box-sizing: border-box;
                                background-color: #FFF;
                                height: 75vh;
                                width: 75vw;
                                padding: 20px;
                                margin: 20px auto;
                                box-shadow: 0 1.5px 4px rgba(0, 0, 0, 0.24), 0 1.5px 6px rgba(0, 0, 0, 0.12);
                                text-align: center; }
                            h1 { font: 300 45px Roboto; }
                            p { font: 300 18px Roboto; }";
        $css_code_slice2 = ".container {
                                margin: 1em;
                                position: fixed;
                                bottom: 0;
                                right: 0; }
                            .container:hover .buttons:not(:last-of-type) {
                                width: 40px;
                                height: 40px;
                                margin: 15px auto 0;
                                opacity: 1; }
                            .container:hover .rotate {
                                background-image: url('https://cbwconline.com/IMG/Codepen/Compose.svg');
                                transform: rotate(0deg); }";
        $css_code_slice3 = ".buttons {
                                display: block;
                                width: 35px;
                                height: 35px;
                                margin: 20px auto 0;
                                text-decoration: none;
                                position: relative;
                                border-radius: 50%;
                                box-shadow: 0px 5px 11px -2px rgba(0, 0, 0, 0.18), 0px 4px 12px -7px rgba(0, 0, 0, 0.15);
                                opacity: 0;
                                transition: .2s; 
                            }
                            .buttons:nth-last-of-type(2) { transition-delay: 20ms; }
                            .buttons:nth-last-of-type(3) { transition-delay: 40ms; }
                            .buttons:nth-last-of-type(4) { transition-delay: 60ms; }
                            .buttons:nth-last-of-type(5) { transition-delay: 80ms; }
                            .buttons:nth-last-of-type(6) { transition-delay: 100ms; }
                            .buttons:nth-last-of-type(1) { width: 56px; height: 56px; opacity: 1; }";
        $css_code_slice4 = ".buttons:nth-last-of-type(2) {
                                background-image: url('".$styleOptions['icon']."');
                                background-size: contain;
                            }
                            .buttons:hover {
                                box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28);
                            }";          
        $css_code_slice5 = "span {
                                width: 100%;
                                height: 100%;
                                border-radius: 50%;
                            }
                            span.rotate {
                                background: #DB4437 url('https://cbwconline.com/IMG/Codepen/Add.svg') center no-repeat;
                                position: absolute;
                                transform: rotate(90deg);
                                transition: .3s;
                            }";
        $css_code_slice6 = "[tooltip]:before {
                                content: attr(tooltip);
                                background: #585858;
                                padding: 5px 7px;
                                margin-right: 10px;
                                border-radius: 2px;
                                color: #FFF;
                                font: 500 12px Roboto;
                                white-space: nowrap;
                                position: absolute;
                                bottom: 20%;
                                right: 100%;
                                visibility: hidden;
                                opacity: 0;
                                transition: .3s;
                            }
                            [tooltip]:hover:before {
                                visibility: visible;
                                opacity: 1;
                            }";

        $css_code = $this->minify_css($css_code_slice1.$css_code_slice2.$css_code_slice3.
                                        $css_code_slice4.$css_code_slice5.$css_code_slice6);
        // $css_code = $css_code_slice1.$css_code_slice2.$css_code_slice3.
        //             $css_code_slice4.$css_code_slice5.$css_code_slice6;

        Storage::disk('local')->put('public/embed.js', $js_code);
        Storage::disk('local')->put('public/embed_style.css', $css_code);

        return view('admin.widgets.embed');
    }

    public function postSendEmbedCode() {
        $widget_comp = WidgetComponent::find(19);
        $widget = Widget::find($widget_comp->widget_id);
        $component = Component::find($widget_comp->component_id);

        $w_tooltip = $widget->name;
        $w_domain = $widget->domain;

        $styleOptions = $component->options;
        $styleOptionsWC = $widget_comp->options;

        $styleOptions['icon'] = ($styleOptionsWC['icon'] != null) ? $styleOptionsWC['icon'] : $styleOptions['icon'];
        $styleOptions['backgroundColor'] = ($styleOptionsWC['backgroundColor'] != null) ? $styleOptionsWC['backgroundColor'] != null : $styleOptions['backgroundColor'];

        /*
		|--------------------------------------------------------------------------
		| JavaScript Management
		|--------------------------------------------------------------------------
		*/
        $js_code_slice1 = "(function (global) {
                                var widget_container;
                                var widget_container = document.getElementById('load_widget');";
        $js_code_slice2 = "var container, nav, button1, button_main, span_button_main, sub_span_button_main;";
        $js_code_slice3 = "link = document.createElement('link');
                            link.href = 'css/embed_style.css';
                            link.rel = 'stylesheet';
                            link.type = 'text/css';
                            link.media = 'all';";
        $js_code_slice4 = "container = document.createElement('div');
                            nav = document.createElement('nav');
                            nav.setAttribute('class', 'container');";
        $js_code_slice5 = "button1 = document.createElement('a');
                            button1.setAttribute('class', 'buttons');
                            button1.setAttribute('tooltip', '".$w_tooltip."');
                            button1.href = '".$w_domain."';
                            button1.style.backgroundColor = '".$styleOptions['backgroundColor']."';";
        $js_code_slice6 = "button_main = document.createElement('a');
                            button_main.setAttribute('class', 'buttons');
                            button_main.setAttribute('tooltip', 'Compose');
                            button_main.href = '';
                            span_button_main = document.createElement('span');
                            sub_span_button_main = document.createElement('span');
                            sub_span_button_main.setAttribute('class', 'rotate');";
        $js_code_slice7 = "span_button_main.appendChild(sub_span_button_main);
                            button_main.appendChild(span_button_main);
                            nav.appendChild(button1);
                            nav.appendChild(button_main);
                            container.appendChild(nav);
                            container.appendChild(link);";
        $js_code_slice8 = "widget_container.style.margin = '1em';
                                widget_container.style.position = 'fixed';
                                widget_container.style.bottom = '0';
                                widget_container.style.right = '0';
                                widget_container.parentNode.replaceChild(container, widget_container);
                            } (this) );";

        $js_code = $this->minify_js($js_code_slice1.$js_code_slice2.$js_code_slice3.$js_code_slice4.
                                    $js_code_slice5.$js_code_slice6.$js_code_slice7.$js_code_slice8);
        // $js_code = $js_code_slice1.$js_code_slice2.$js_code_slice3.$js_code_slice4.
        //             $js_code_slice5.$js_code_slice6.$js_code_slice7.$js_code_slice8;

        /*
		|--------------------------------------------------------------------------
		| CSS Management
		|--------------------------------------------------------------------------
        */
        $css_code_slice1 = "body {
                                background-color: #F2F2F2;
                                margin: 0;
                                max-height: 100vh; }
                            .header {
                                background: #4285f4;
                                width: 100%;
                                height: 56px;
                                box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28); }
                            .main {
                                box-sizing: border-box;
                                background-color: #FFF;
                                height: 75vh;
                                width: 75vw;
                                padding: 20px;
                                margin: 20px auto;
                                box-shadow: 0 1.5px 4px rgba(0, 0, 0, 0.24), 0 1.5px 6px rgba(0, 0, 0, 0.12);
                                text-align: center; }
                            h1 { font: 300 45px Roboto; }
                            p { font: 300 18px Roboto; }";
        $css_code_slice2 = ".container {
                                margin: 1em;
                                position: fixed;
                                bottom: 0;
                                right: 0; }
                            .container:hover .buttons:not(:last-of-type) {
                                width: 40px;
                                height: 40px;
                                margin: 15px auto 0;
                                opacity: 1; }
                            .container:hover .rotate {
                                background-image: url('https://cbwconline.com/IMG/Codepen/Compose.svg');
                                transform: rotate(0deg); }";
        $css_code_slice3 = ".buttons {
                                display: block;
                                width: 35px;
                                height: 35px;
                                margin: 20px auto 0;
                                text-decoration: none;
                                position: relative;
                                border-radius: 50%;
                                box-shadow: 0px 5px 11px -2px rgba(0, 0, 0, 0.18), 0px 4px 12px -7px rgba(0, 0, 0, 0.15);
                                opacity: 0;
                                transition: .2s; 
                            }
                            .buttons:nth-last-of-type(2) { transition-delay: 20ms; }
                            .buttons:nth-last-of-type(3) { transition-delay: 40ms; }
                            .buttons:nth-last-of-type(4) { transition-delay: 60ms; }
                            .buttons:nth-last-of-type(5) { transition-delay: 80ms; }
                            .buttons:nth-last-of-type(6) { transition-delay: 100ms; }
                            .buttons:nth-last-of-type(1) { width: 56px; height: 56px; opacity: 1; }";
        $css_code_slice4 = ".buttons:nth-last-of-type(2) {
                                background-image: url('".$styleOptions['icon']."');
                                background-size: contain;
                            }
                            .buttons:hover {
                                box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28);
                            }";          
        $css_code_slice5 = "span {
                                width: 100%;
                                height: 100%;
                                border-radius: 50%;
                            }
                            span.rotate {
                                background: #DB4437 url('https://cbwconline.com/IMG/Codepen/Add.svg') center no-repeat;
                                position: absolute;
                                transform: rotate(90deg);
                                transition: .3s;
                            }";
        $css_code_slice6 = "[tooltip]:before {
                                content: attr(tooltip);
                                background: #585858;
                                padding: 5px 7px;
                                margin-right: 10px;
                                border-radius: 2px;
                                color: #FFF;
                                font: 500 12px Roboto;
                                white-space: nowrap;
                                position: absolute;
                                bottom: 20%;
                                right: 100%;
                                visibility: hidden;
                                opacity: 0;
                                transition: .3s;
                            }
                            [tooltip]:hover:before {
                                visibility: visible;
                                opacity: 1;
                            }";

        $css_code = $this->minify_css($css_code_slice1.$css_code_slice2.$css_code_slice3.
                                        $css_code_slice4.$css_code_slice5.$css_code_slice6);
        // $css_code = $css_code_slice1.$css_code_slice2.$css_code_slice3.
        //             $css_code_slice4.$css_code_slice5.$css_code_slice6;

        $items = array();
        array_push($items, $js_code, $css_code);
        
        return $js_code;
    }
}
