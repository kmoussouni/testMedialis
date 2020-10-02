<?php 

declare(strict_types = 1);

namespace App\Service;

interface RendererInterface
{
    public function render($template, $data = []) : string;
}