<?php

/**
 * View Renderer
 * @link https://github.com/lleocastro/view-renderer
 * @license https://github.com/lleocastro/view-renderer/blob/master/LICENSE
 * @copyright 2016 Leonardo Carvalho <leonardo_carvalho@outlook.com>
 */

namespace View;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Object PSR-7 Response
 * @package system/kernel/view/
 */
class Renderer
{
    /**
     * @var string
     */
    private $templatePath = '';

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param string $templatePath
     * @param array $attributes
     */
    public function __construct($templatePath, array $attributes = [])
    {
        if(substr($templatePath, -1) !== '/'):
            $templatePath .= '/';
        endif;

        $this->templatePath = $templatePath;
        $this->attributes = array_map("htmlspecialchars", $attributes);
    }

    /**
     * Renderiza o Template
     *
     * @param ResponseInterface $response 
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, array $data = [])
    {
        $response->getBody()->write(
            $this->process($template, array_map("htmlspecialchars", $data))
        );
        
        return $response;
    }

    /**
     * Processa o template e retorna o resultado como string
     *
     * @param string $template
     * @param array $data
     * @throws RuntimeException (retornará uma exceção caso o template não exista)
     * @return mixed
     */
    private function process($template, array $data = []) 
    {
        $template = $this->templatePath . $template;
        
        /**
        * Verifica se o template se encontra no caminho indicado
        * @throws RuntimeException
        */
        if(!is_file($template)):
            throw new RuntimeException("The '{$template}' not found.");
        endif;
        
        ob_start();
        $this->includeScope($template, array_merge($this->attributes, $data));
        return ob_get_clean();
    }

    /**
     * @param string $template
     * @param array $data
     */
    protected function includeScope($template, array $data)
    {
        extract($data);
        include $template;
    }
    
}