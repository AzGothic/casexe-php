<?php

namespace app\base;

use App;

/**
 * View class definition
 */
class View
{
    public $layout = 'layout/index';
    public $title;
    public $content;

    /**
     * Rendering partials
     * @param string|array $view
     * @param array $params
     * @return string html
     */
    public function partial($view, $params = null) {
        $module = 'index';
        if (is_array($view)) {
            if (!empty($view[1]))
                $module = $view[1];
            $view = $view[0];
        }

        if ($module == 'index')
            $__viewPath = VIEW_PATH . "$view.php";
        else
            $__viewPath = MODULE_PATH . "$module/view/$view.php";
        $__viewParams = $params;
        unset($module, $view, $params);

        ob_start();
        if ($__viewParams) {
            foreach ($__viewParams as $param => $value) {
                if ($param == '__viewPath' or $param == '__viewParams') {
                    continue;
                }
                ${$param} = $value;
            }
        }
        require $__viewPath;
        $partial = ob_get_contents();
        ob_end_clean();

        return $partial;
    }

    /**
     * Rendering
     * @param string $view
     * @param array $params
     * @return string html
     */
    public function render($view, $params = null) {
        $this->content = $this->partial($view, $params);

        return $this->partial($this->layout);
    }
}

