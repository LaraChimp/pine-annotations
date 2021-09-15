<?php

namespace LaraChimp\PineAnnotations\Concerns;

trait NamespaceToPathConvertable
{
    /**
     * Convert the given namespace to a file path.
     *
     * @param  string  $namespace
     * @param  string  $base
     * @return string
     */
    public function getPathFromNamespace($namespace, $base = null)
    {
        $appNamespace = $this->getAppNamespace();

        // Remove the app namespace from the namespace if it is there
        if (substr($namespace, 0, strlen($appNamespace)) == $appNamespace) {
            $namespace = substr($namespace, strlen($appNamespace));
        }
        $path = str_replace('\\', '/', trim($namespace, ' \\'));

        // trim and return the path
        return ($base ?: app_path()).'/'.$path;
    }

    /**
     * Get the application namespace.
     *
     * @return string
     */
    protected function getAppNamespace()
    {
        return app()->getNamespace();
    }
}
