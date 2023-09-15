<?php

namespace App\View\Components\form;

use Illuminate\View\Component;

class MetodePembayaran extends Component
{
    protected $data;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($kasBank)
    {
        $this->data = $kasBank;
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
            'akunPiutang' => $this->data['akunPiutang'],
        ];
        return view('components.form.metode-pembayaran', $data);
    }
}
