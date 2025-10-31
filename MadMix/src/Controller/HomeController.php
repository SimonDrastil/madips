<?php
declare(strict_types=1);

namespace MadMix\Controller;

use MadMix\Model\Category;
use MadMix\Model\Template;

final class HomeController extends BaseController
{
    public function index(): void
    {
        $categories = Category::all();
        $templates = Template::allPublic();
        $featured = array_slice($templates, 0, 3);
        $this->view('home', compact('categories', 'featured'));
    }
}
