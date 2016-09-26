<?php 

use View\Renderer;

class RendererTest extends PHPUnit_Framework_TestCase
{
    public function testRenderer() 
    {
        $view = new Renderer("tests/");

        $view->render(new Response(), "hello.php", [
            "hello" => "Olá!"
        ]);
        
        //...
        
    }
    
    
    
}