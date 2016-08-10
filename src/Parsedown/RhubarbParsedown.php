<?php

namespace Rhubarb\Website\Parsedown;

use Rhubarb\Crown\Application;

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

        foreach($directory as $dir){
            if ($dir[0] == "."){
                continue;
            }

            if (!is_file($scanPath."/".$dir)){
                continue;
            }

            $tabId = preg_replace("/\\W/", "", strtolower($dir));

            $info = pathinfo($scanPath."/".$dir);
            $newLine = ["text" => "``` ".strtolower($info["extension"])." file[".$dir."]"];
            $element = $parser->blockFencedCode($newLine);
            $element = $parser->blockFencedCodeComplete($element);
            $element = $element["element"];

            $attributes = [];

            foreach($element["text"]["attributes"] as $att => $value) {
                $attributes[] = $att."=\"".$value."\"";
            }

            $tabs[] = [
                "file" => $dir,
                "id" => $tabId,
                "html" => "<div class='c-tab js-tab' id='$tabId'>
                                    <div class='c-tab__content'>
                                    <pre ".implode(" ",$attributes)."><code>".trim($element["text"]["text"])."</code>
                                    </pre></div>
                                </div>"
            ];
        }

        $tabUl = '
            <div class="js-tabs c-tabs">
                <div class="c-tabs-nav">
                    ';

        foreach($tabs as $tab){
            $tabUl .= '<a href="#/" class="c-tabs-nav__link js-tab-link" data-tab="'.$tab["id"].'">'.$tab["file"].'</a>';
        }

        $tabUl .= '</div>';

        foreach($tabs as $tab){
            $tabUl .= $tab["html"];
        }

        $tabUl .= '
            </div>';

        return $tabUl;
    }

    protected function blockFencedCode($Line)
    {
        if (preg_match('/^['.$Line['text'][0].']{3,}[ ]*dir[[]([^]]+)[]]/', $Line['text'], $match))
        {
            $scanPath = $this->relativeDir.'/'.$match[1];
            $html = self::getHtmlForExampleDirectory($scanPath);

            return array(
                'char' => $Line['text'][0],
                'group' => true,
                'markup' => $html
            );
        }

        if (preg_match('/^['.$Line['text'][0].']{3,}[ ]*([\w-]+)?/', $Line['text'], $matches))
        {
            $Element = array(
                'name' => 'code',
                'text' => '',
            );

            if (isset($matches[1]))
            {
                $class = 'language-'.$matches[1];

                $Element['attributes'] = array(
                    'class' => $class,
                );
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

            if (preg_match("/file[[]([^]]+)[]]/", $Line["text"], $match)){
                $file = $match[1];
                $content = file($this->relativeDir.'/'.$file);

                if (preg_match("/lines[[](\\d+)(-(\\d+))?[]]/", $Line["text"], $match)){
                    $from = $match[1];
                    $to = (!$match[3]) ? sizeof($content) : $match[3];

                    $content = array_slice($content, $from, $to - $from);
                }

                $Element["text"] = implode("", $content);
                $request = Application::current()->request();
                $Block['element']['attributes']['data-url'] = "/view/".$request->uri."/".$file;
            }

            if (preg_match("/highlight[[]([^]]+)[]]/", $Line["text"], $match)){
                $Block['element']['attributes']['data-line'] = $match[1];
            }

            if (preg_match("/demo[[]([^]]+)[]]/", $Line["text"], $match)){
                $Block['element']['attributes']['data-demo-url'] = $match[1];
            }

            return $Block;
        }
    }

    protected function blockFencedCodeContinue($Line, $Block)
    {
        if (isset($Block['complete']))
        {
            return;
        }

        if (!isset($Block['element']))
        {
            $Block['complete'] = true;
            return $Block;
        }

        if (isset($Block['interrupted']))
        {
            $Block['element']['text']['text'] .= "\n";

            unset($Block['interrupted']);
        }

        if (preg_match('/^'.$Block['char'].'{3,}[ ]*$/', $Line['text']))
        {
            $Block['element']['text']['text'] = trim($Block['element']['text']['text']);

            $Block['complete'] = true;

            return $Block;
        }

        $Block['element']['text']['text'] .= "\n".$Line['body'];;

        return $Block;
    }

    protected function blockFencedCodeComplete($Block)
    {
        if (!isset($Block['element']))
        {
            return $Block;
        }

        return parent::blockFencedCodeComplete($Block);
    }
}