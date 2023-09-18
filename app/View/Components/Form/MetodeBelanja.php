<?php

namespace App\View\Components\form;

use Illuminate\View\Component;

class MetodeBelanja extends Component
{
    protected $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($akunBelanja)
    {
        $this->data = $akunBelanja;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data = [
            'akunKas' => $this->data['akunKas'],
            'akunBank' => $this->data['akunBank'],
            'akunHutang' => $this->data['akunHutang'],
        ];
        return view('components.form.metode-belanja', $data);
    }
}
