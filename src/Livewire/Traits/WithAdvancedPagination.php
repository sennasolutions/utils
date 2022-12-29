<?php

namespace Senna\Utils\Livewire\Traits;

use Livewire\WithPagination;

trait WithAdvancedPagination
{
    public $scrollToTopElement = 'body';
    public $perPage = 10;

    use WithPagination {
        setPage as public setPageOriginal;
    }

    public function setPage($page, $pageName = 'page') {
        $this->setPageOriginal($page, $pageName);
        $this->scrollToTop();

        if (isset($this->selectPage)) {
            $this->selectPage = false;
        }
    }

    public function scrollToTop()
    {
        $this->emit('scrollToTop', $this->scrollToTopElement);
    }

    public function mountWithAdvancedPagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        session()->put('perPage', $value);
    }

    public function applyPagination($query)
    {
        return $query->paginate($this->perPage, ['*'], 'page');
    }
}
