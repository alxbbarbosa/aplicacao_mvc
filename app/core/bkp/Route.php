<?php

class Route
{

    private $uri = [];
    private $controller = [];

    public function add($uri, $callback = NULL)
    {
        $this->uri[] = $uri;

        if ($callback != NULL) {
            $this->controller[$uri] = $callback;
        }
    }

    public function call()
    {
        $uriGetted = isset($_GET['url']) ? filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL) : '/';

        foreach ($this->uri as $key => $uriSaved) {

            if (preg_match("#^$uriGetted#", trim($uriSaved, '/'))) {

                if (key_exists($uriSaved, $this->controller)) {
                    if (is_string($this->controller[$uriSaved])) {
                        $useMethod = $this->controller[$uriSaved];

                        new $useMethod;

                        return TRUE;
                    } else if (is_callable($this->controller[$uriSaved])) {

                        call_user_func($this->controller[$uriSaved]);

                        return TRUE;
                    }
                }
            }
        }
        return FALSE;
    }
}
