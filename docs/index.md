Welcome to Rhubarb PHP
======================

1. list
1. etc

```php
class MarkdownUrlHandler extends UrlHandler
{
    private $rootPath;

    function __construct($rootPath, $childUrlHandlers = [])
    {
        $this->rootPath = $rootPath;

        parent::__construct($childUrlHandlers);
    }

    /**
     * Return the response if appropriate or false if no response could be generated.
     *
     * @param mixed $request
     * @return bool
     */
    protected function generateResponseForRequest($request = null)
    {
        $url = $request->UrlPath;

        // Look to see if there's a markdown file at this location.
        if (file_exists($this->rootPath . "/" . $url . ".md")) {
            $markDownRaw = file_get_contents($this->rootPath . "/" . $url . ".md");

            return MarkdownExtended($markDownRaw);
        }
    }
}
```

~~~ php
class MarkdownUrlHandler extends UrlHandler
{
    private $rootPath;

    function __construct($rootPath, $childUrlHandlers = [])
    {
        $this->rootPath = $rootPath;

        parent::__construct($childUrlHandlers);
    }

    /**
     * Return the response if appropriate or false if no response could be generated.
     *
     * @param mixed $request
     * @return bool
     */
    protected function generateResponseForRequest($request = null)
    {
        $url = $request->UrlPath;

        // Look to see if there's a markdown file at this location.
        if (file_exists($this->rootPath . "/" . $url . ".md")) {
            $markDownRaw = file_get_contents($this->rootPath . "/" . $url . ".md");

            return MarkdownExtended($markDownRaw);
        }
    }
}
~~~