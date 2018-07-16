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
    public function embedResponse(Request $request) {
        $widget_id = $request->filled('widget_id') ? $request->get('widget_id') : false;
        $widget = Widget::with('components')->find($widget_id);

        foreach($widget->components as $component) {
            $custom_options = WidgetComponent::where('widget_id', $widget_id)->where('component_id', $component->id)->first();
            $component->options = serialize(array_merge((array) $component->options, (array) $custom_options->options));
        }

        return response($widget, 200);
    }
}
