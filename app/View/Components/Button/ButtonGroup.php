<?php

namespace App\View\Components\button;

use Illuminate\View\Component;

class ButtonGroup extends Component
{
    protected $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($buttonGroup)
    {
        $this->data = $buttonGroup;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data = [
            'title' => $this->data['title'],
            'createLarantuka' => $this->data['createLarantuka'],
            'createWaiwerang' => $this->data['createWaiwerang'],
            'createPasarBaru' => $this->data['createPasarBaru'],
        ];
        return view('components.button.button-group', $data);
    }
}
