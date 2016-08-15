<?php

namespace Rhubarb\Website\Parsedown;

use Rhubarb\Crown\Application;
use Rhubarb\Crown\Request\Request;
use Rhubarb\Crown\Response\HtmlResponse;

class RhubarbParsedown extends \ParsedownExtra
{
    /**
     * @var
     */
    private $relativeDir;

    public function __construct($relativeDir)
    {
        parent::__construct();

        $this->relativeDir = $relativeDir;
    }

    public static function getHtmlForExampleDirectory($scanPath)
    {
        $directory = scandir($scanPath);

        $elements = [];
        $tabs = [];
        $parser = new RhubarbParsedown($scanPath);

        foreach ($directory as $dir) {
            if ($dir[0] == ".") {
                continue;
            }

            if (!is_file($scanPath . "/" . $dir)) {
                continue;
            }

            $tabId = preg_replace("/\\W/", "", strtolower($dir));

            $info = pathinfo($scanPath . "/" . $dir);
            $newLine = ["text" => "``` " . strtolower($info["extension"]) . " file[" . $dir . "]"];
            $element = $parser->blockFencedCode($newLine);
            $element = $parser->blockFencedCodeComplete($element);
            $element = $element["element"];

            $attributes = [];

            foreach ($element["text"]["attributes"] as $att => $value) {
                $attributes[] = $att . "=\"" . $value . "\"";
            }

            $tabs[] = [
                "file" => $dir,
                "id" => $tabId,
                "html" => "<div class='c-tab js-tab' id='$tabId'>
                                    <div class='c-tab__content'>
                                    <pre " . implode(" ", $attributes) . "><code>" . trim($element["text"]["text"]) . "</code>
                                    </pre></div>
                                </div>"
            ];
        }

        $tabUl = '
            <div class="js-tabs c-tabs">
                <div class="c-tabs-nav">
                    ';

        foreach ($tabs as $tab) {
            $tabUl .= '<a href="#/" class="c-tabs-nav__link js-tab-link" data-tab="' . $tab["id"] . '">' . $tab["file"] . '</a>';
        }

        $tabUl .= '</div>';

        foreach ($tabs as $tab) {
            $tabUl .= $tab["html"];
        }

        $tabUl .= '
            </div>';

        return $tabUl;
    }

    public static function getHtmlForDemo($demoPath, $request = null)
    {
        if (file_exists($demoPath)) {
            // Include all the php files in the folder.
            $directory = dirname($demoPath);
            $scan = scandir($directory);

            foreach($scan as $dir){
                if ($dir[0] == "."){
                    continue;
                }

                if (!preg_match("/\\.php$/", $dir)){
                    continue;
                }

                include_once($directory."/".$dir);
            }

            // Read the example leaf to find the class name and namespace
            $source = file_get_contents($demoPath);

            if (preg_match("/namespace ([^;]+);/", $source, $namespace)){
                if (preg_match("/class ([\\w]+)/", $source, $class)){
                    $leafClass = $namespace[1]."\\".$class[1];
                    $leaf = new $leafClass();

                    /**
                     * @var HtmlResponse $response
                     */
                    $response = $leaf->generateResponse($request);
                    $html = $response->getContent();

                    $code = RhubarbParsedown::getHtmlForExampleDirectory(dirname($demoPath));
                    $html .= $code;
                    $html = '<div class="c-example">'.$html.'</div>';
                    return $html;
                }
            }
        }

        return false;
    }

    protected function blockFencedCode($Line)
    {
        if (preg_match('/^[' . $Line['text'][0] . ']{3,}[ ]*dir[[]([^]]+)[]]/', $Line['text'], $match)) {
            $scanPath = $this->relativeDir . '/' . $match[1];
            $html = self::getHtmlForExampleDirectory($scanPath);

            return array(
                'char' => $Line['text'][0],
                'group' => true,
                'markup' => $html
            );
        }

        if (preg_match('/^[' . $Line['text'][0] . ']{3,}[ ]*demo[[]([^]]+)[]]/', $Line['text'], $match)) {
            $scanPath = $this->relativeDir . '/' . $match[1];
            $html = self::getHtmlForDemo($scanPath, Request::current());

            return array(
                'char' => $Line['text'][0],
                'group' => true,
                'markup' => $html
            );
        }

        if (preg_match('/^[' . $Line['text'][0] . ']{3,}[ ]*([\w-]+)?/', $Line['text'], $matches)) {
            $Element = array(
                'name' => 'code',
                'text' => '',
            );

            if (isset($matches[1])) {
                $language = $matches[1];

                $class = 'language-' . $language;

                $Element['attributes'] = array(
                    'class' => $class,
                );

                if ($language == "bash"){
                    $Element['attributes']['class'] = $Element['attributes']['class']." command-line";
                }
            }

            $Block = array(
                'char' => $Line['text'][0],
                'element' => array(
                    'name' => 'pre',
                    'handler' => 'element',
                    'text' => &$Element,
                ),
            );

            //$Block['element']['attributes']['class'] = 'line-numbers';

            if (preg_match("/file[[]([^]]+)[]]/", $Line["text"], $match)) {
                $file = $match[1];
                $content = file($this->relativeDir . '/' . $file);

                if (preg_match("/lines[[](\\d+)(-(\\d+))?[]]/", $Line["text"], $match)) {
                    $from = $match[1];
                    $to = (!isset($match[3])) ? sizeof($content) : $match[3];

                    $content = array_slice($content, $from, $to - $from);
                }

                $Element["text"] = implode("", $content);
                $request = Application::current()->request();
                $Block['element']['attributes']['data-url'] = $this->generateGitHubUrl($file, $request->urlPath);
//                $Block['element']['attributes']['data-url'] = "/view/" . $request->uri . "/" . $file;//github url
            }

            if (preg_match("/highlight[[]([^]]+)[]]/", $Line["text"], $match)) {
                $Block['element']['attributes']['data-line'] = $match[1];
            }

            if (preg_match("/demo[[]([^]]+)[]]/", $Line["text"], $match)) {
                $Block['element']['attributes']['data-demo-url'] = $match[1];
            }

            return $Block;
        }
    }

    protected function blockFencedCodeContinue($Line, $Block)
    {
        if (isset($Block['complete'])) {
            return;
        }

        if (!isset($Block['element'])) {
            $Block['complete'] = true;
            return $Block;
        }

        if (isset($Block['interrupted'])) {
            $Block['element']['text']['text'] .= "\n";

            unset($Block['interrupted']);
        }

        if (preg_match('/^' . $Block['char'] . '{3,}[ ]*$/', $Line['text'])) {
            $Block['element']['text']['text'] = trim($Block['element']['text']['text']);

            $Block['complete'] = true;

            return $Block;
        }

        $Block['element']['text']['text'] .= "\n" . $Line['body'];;

        return $Block;
    }

    protected function blockFencedCodeComplete($Block)
    {
        if (!isset($Block['element'])) {
            return $Block;
        }

        return parent::blockFencedCodeComplete($Block);
    }

    /**
     * @param $file that you want to be displayed on github, relative to the code e.g "/examples/helloWorld.php
     * @param $urlPath e.g. $request->urlPath "/manual/module.leaf"
     * removes "manual/" and "/index" (if it exists)
     * @return string the url to the file on GitHub
     */
    protected function generateGitHubUrl($file, $urlPath)
    {
        $urlArray = explode("/", $urlPath);
        return "https://github.com/RhubarbPHP/" . $urlArray[2] . "/blob/master/docs/" . $file;
    }
}