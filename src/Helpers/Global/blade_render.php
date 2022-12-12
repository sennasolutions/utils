<?php

use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\View\Component;

/**
 * Evaluate and render a Blade string to HTML.
 *
 * @param  string  $string
 * @param  array  $data
 * @param  bool  $deleteCachedView
 * @return string
 */
function blade_render($string, $data = [], $deleteCachedView = false)
{
    $component = new class($string) extends Component
    {
        protected $template;

        public function __construct($template)
        {
            $this->template = $template;
        }

        public function render()
        {
            return $this->template;
        }
    };

    $view = Container::getInstance()
                ->make(ViewFactory::class)
                ->make($component->resolveView(), $data);

    return tap($view->render(), function () use ($view, $deleteCachedView) {
        if ($deleteCachedView) {
            unlink($view->getPath());
        }
    });
}

function blade_render_safe($string, $data = [],  $deleteCachedView = false) {
    try {
        return blade_render($string, $data, $deleteCachedView);
    } catch (\Throwable $th) {
        return "Error: " . $th->getMessage();
    }
}