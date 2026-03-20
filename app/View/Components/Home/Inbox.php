<?php

namespace App\View\Components\Home;

use Illuminate\View\Component;

class Inbox extends Component
{
    public $heading;
    public $subheading;
    
    public function __construct($heading = 'Inbox', $subheading = 'Check and manage your messages')
    {
        $this->heading = $heading;
        $this->subheading = $subheading;
    }
    
    public function render()
    {
        return view('home.inbox');
    }
}