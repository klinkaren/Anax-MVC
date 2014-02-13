<?php

namespace Anax\View;

/**
 * A view container, store all views per region, render at will.
 *
 */
class CViewContainerBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;



    /**
     * Properties
     *
     */
    private $views = []; // Array for all views
    private $suffix;     // Template file suffix
    private $path;       // Base path for views



    /**
     * Add a view to be included as a template file.
     *
     * @param string $template the name of the template file to include
     * @param array  $data     variables to make available to the view, default is empty
     *
     * @return class as the added view
     */
    public function add($template, $data = []) 
    {
        $tpl = $this->path . $template . $this->suffix;
        $view = new CViewBasic($tpl, $data);
        $view->setDI($this->di);
        $this->views[] = $view;
        return $view;
    }



    /**
     * Set the suffix of the template files to include.
     *
     * @param string $suffix file suffix of template files, append to filenames for template files
     *
     * @return $this
     */
    public function setFileSuffix($suffix) 
    {
        $this->suffix = $suffix;
    }



    /**
     * Set base path where  to find views.
     *
     * @param string $path where all views reside
     *
     * @return $this
     */
    public function setBasePath($path) 
    {
        if (!is_dir($path)) {
            throw new \Exception("Base path for views is not a directory: " . $path);
        }
        $this->path = rtrim($path, '/') . '/';
    }



    /**
     * Render all views.
     *
     * @return $this
     */
    public function render() 
    {
        foreach ($this->views as $view) {
            $view->render();
        }

        return $this;
    }
}