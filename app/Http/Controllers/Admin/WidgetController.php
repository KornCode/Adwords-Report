<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\UserMeta;
use Validator;

use Illuminate\Http\Request;
use App\Widget;
use App\Component;
use App\WidgetComponent;

class WidgetController extends Controller
{
    private function registerWidget($name, $user_id, $domain, $align) {
        $widget = new Widget;
        $widget->name = $name;
        $widget->user_id = $user_id;
        $widget->domain = $domain;
        $widget->align = $align;
        $widget->save();

        return $widget;
    }

    private function registerComponent($name, $options) {
        $component = new Component;
        $component->name = $name;
        $component->options = serialize($options);
        $component->save();

        return $component;
    }

    private function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    } 

    // HTML Minifier
    private function minify_html($input) {
        if(trim($input) === "") return $input;
        // Remove extra white-space(s) between HTML attribute(s)
        $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
            return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
        }, str_replace("\r", "", $input));
        // Minify inline CSS declaration(s)
        if(strpos($input, ' style=') !== false) {
            $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function($matches) {
                return '<' . $matches[1] . ' style=' . $matches[2] . minify_css($matches[3]) . $matches[2];
            }, $input);
        }
        if(strpos($input, '</style>') !== false) {
        $input = preg_replace_callback('#<style(.*?)>(.*?)</style>#is', function($matches) {
            return '<style' . $matches[1] .'>'. minify_css($matches[2]) . '</style>';
        }, $input);
        }
        if(strpos($input, '</script>') !== false) {
        $input = preg_replace_callback('#<script(.*?)>(.*?)</script>#is', function($matches) {
            return '<script' . $matches[1] .'>'. minify_js($matches[2]) . '</script>';
        }, $input);
        }
        return preg_replace(
            array(
                // t = text
                // o = tag open
                // c = tag close
                // Keep important white-space(s) after self-closing HTML tag(s)
                '#<(img|input)(>| .*?>)#s',
                // Remove a line break and two or more white-space(s) between tag(s)
                '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
                '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
                '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
                '#<(img|input)(>| .*?>)<\/\1>#s', // reset previous fix
                '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
                '#(?<=\>)(&nbsp;)(?=\<)#', // --ibid
                // Remove HTML comment(s) except IE comment(s)
                '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
            ),
            array(
                '<$1$2</$1>',
                '$1$2$3',
                '$1$2$3',
                '$1$2$3$4$5',
                '$1$2$3$4$5$6$7',
                '$1$2$3',
                '<$1$2',
                '$1 ',
                '$1',
                ""
            ),
        $input);
    }

    /**
     * Show Widget
     *
     * @return \Illuminate\Http\Response
     */
    public function showWidgets() {
        $data['widgets'] = Widget::all();
        $data['components'] = Component::all();
        $data['widget_component'] = WidgetComponent::all();

        $data['embed'] = array();
        foreach ($data['widget_component'] as $wc_each) {
            $embed_temp = array(
                'widget_id' => $wc_each->widget_id,
                'html_code' => "<script>var s = document.createElement('script');s.src = 'http://localhost:8000/embed.js';s.async = true;window.kodsana_options = {widget_id: ".$wc_each->widget_id."};document.body.appendChild(s);</script><div id='load_widget'>Loading...</div>",
                'name' => Widget::find($wc_each->widget_id)->name
            );
            array_push($data['embed'], $embed_temp);
        }

        $data['embed'] = $this->unique_multidim_array($data['embed'], 'widget_id');

        return view('admin.widgets.index', $data);
    }   

    /**
     * Show Create Widget Form
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateWidget() {
        $data['user_data'] = User::select('id', 'email')->get();
        return view('admin.widgets.create.create_widget', $data);
    } 

    public function postCreateWidget(Request $request) {
        $validator = Validator::make($request->all(), [
            'widget_name' => 'required|max:255',
            'user_id' => 'required',
            'domain' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        };

        $name = $request->get('widget_name');
        $user_id = $request->get('user_id');
        $domain = $request->get('domain');
        $align = $request->get('alignment');
        
        $this->registerWidget($name, $user_id, $domain, $align);

        return redirect()->route('admin.widgets.index');
    }

    public function showEditWidget($widget_id) {
        $data['widget'] = Widget::find($widget_id);
        $data['user_data'] = User::select('id', 'email')->get();

     	return view('admin.widgets.edit.edit_widget', $data);
    }

    public function postEditWidget(Request $request) {
        $validator = Validator::make($request->all(), [
            'widget_id' => 'required',
            'widget_name' => 'required|max:255',
            'user_id' => 'required',
            'domain' => 'required|max:255'
        ]);
		if ($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
        };
        
		$widget = Widget::find($request->get('widget_id'));
		$widget->name = $request->get('widget_name');
        $widget->user_id = $request->get('user_id');
        $widget->domain = $request->get('domain');
		$widget->save();

		return redirect()->route('admin.widgets.index');
    }

    public function postDeleteWidget(Request $request) {
        $widget = Widget::find($request->get('widget_id'));
        $name = $widget->name;
        
        $validator = Validator::make($request->all(), [
             'delete_id' => 'required|in:'.$widget->id,
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $count = Widget::where('name', '=', $name)->groupBy('name')->count();

        if ($count === 1) {
            $wid_comp = WidgetComponent::where('widget_id', '=', $request->get('widget_id'))->get();
            foreach ($wid_comp as $wid_comp_each) {
                $wid_comp_each->delete();
            }
        }

        $widget->delete();
        
        return redirect()->route('admin.widgets.index');
    }
    
    /**
     * Show Create Component Form
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateComponent() {
        return view('admin.widgets.create.create_component');
    } 

    public function postCreateComponent(Request $request) {
        $validator = Validator::make($request->all(), [
            'icon' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        };

        $options = $request->all();
        $options = array_filter($options); // remove null value
        $options = array_slice($options, 1); // remove _token

        $this->registerComponent($request->get('icon'), $options);

        return redirect()->route('admin.widgets.index');
    }

    public function showEditComponent($component_id) {
        $data['component'] = Component::find($component_id);
     	return view('admin.widgets.edit.edit_component', $data);
    }

    public function postEditComponent(Request $request) {
        $validator = Validator::make($request->all(), [
            'component_id' => 'required',
            'icon' => 'required'
        ]);
		if ($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
		};
		$component = Component::find($request->get('component_id'));
        $component->name = $request->get('icon');

        $options = $request->all();
        $options = array_filter($options); // remove null value
        $options = array_slice($options, 1); // remove _token

        $component->options = serialize($options);
		$component->save();

		return redirect()->route('admin.widgets.index');
    }

    public function postDeleteComponent(Request $request){
        $component = Component::find($request->get('component_id'));
        $validator = Validator::make($request->all(), [
             'delete_id' => 'required|in:'.$component->id,
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $component->delete();
        return redirect()->route('admin.widgets.index');
    }

    /**
     * Show Create Widget Component Form
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateWidgetComponent() {
        $data['wc_comp_data'] = Component::select('id', 'name')->get();
        $data['wc_widget_data'] = Widget::select('id', 'name')->get();
        return view('admin.widgets.create.create_widget_component', $data);
    } 

    public function postCreateWidgetComponent(Request $request) {
        $validator = Validator::make($request->all(), [
            'icon' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        };

        $options = $request->all();
        $options = array_filter($options); // remove null value
        $options = array_slice($options, 4); // remove _token, wid_comp_id, wc_widget_id, wc_comp_id

        $widget_id = $request->get('wc_widget_id');
        $widget = Widget::find($widget_id);

        // Attach component to widget
        $comp_id = $request->get('wc_comp_id');
        $widget->components()->syncWithoutDetaching($comp_id);

        // Save custom options to widget's component
        $component_relation = new WidgetComponent;
        $component_relation = WidgetComponent::where('widget_id', $widget_id)->where('component_id', $comp_id)->first();
        $component_relation->options = serialize($options);
        $component_relation->save();

        return redirect()->route('admin.widgets.index');
    }

    public function showEditWidgetComponent($wid_comp_id) {
        $data['wc_comp_data'] = Component::select('id', 'name')->get();
        $data['wc_widget_data'] = Widget::select('id', 'name')->get();
        $data['wc_data'] = WidgetComponent::find($wid_comp_id);
     	return view('admin.widgets.edit.edit_widget_component', $data);
    }

    public function postEditWidgetComponent(Request $request) {
        $validator = Validator::make($request->all(), [
            'wid_comp_id' => 'required',
            'wc_widget_id' => 'required',
            'wc_comp_id' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        };

        $wid_comp = WidgetComponent::find($request->get('wid_comp_id'));

        $wid_comp->widget_id = $request->get('wc_widget_id');
        $wid_comp->component_id = $request->get('wc_comp_id');

        $options = $request->all();
        $options = array_filter($options); // remove null value
        $options = array_slice($options, 4); // remove _token, wid_comp_id, wc_widget_id, wc_comp_id

        $wid_comp->options = serialize($options);

        $wid_comp->save();

		return redirect()->route('admin.widgets.index');
    }

    public function postDeleteWidgetComponent(Request $request){
        $wid_comp = WidgetComponent::find($request->get('wid_comp_id'));
        $validator = Validator::make($request->all(), [
             'delete_id' => 'required|in:'.$wid_comp->id,
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $wid_comp->delete();
        return redirect()->route('admin.widgets.index');
    }
}
