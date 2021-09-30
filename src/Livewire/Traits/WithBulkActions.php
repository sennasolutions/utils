<?php

namespace Senna\Utils\Livewire\Traits;

trait WithBulkActions
{
    public $selectPage = false;
    public $selectAll = false;
    /**
     * An array of ids to be selected.
     *
     * @var array
     */
    public $selected = [];

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function addToSelection($add) {
        $this->selected = collect($this->selected)->merge($add)->unique()->values()->toArray();
    }

    public function selectOrDeselect($item)
    {
        $items = is_iterable($item) ? $item : collect($item);  
        $selected = collect($this->selected);
        
        foreach($items as $item) {
            if ($selected->contains($item)) {
                $this->subtractFromSelection($item);
            } else {
                $this->addToSelection($item);
            }
        }
    }

    public function subtractFromSelection($subtract) {
        $this->selected = collect($this->selected)->diff($subtract)->unique();
    }

    public function isSelected($id) {
        return collect($this->selected)->contains(strval($id));
    }

    public function updatedSelectPage($value) {
        if ($value) {
            $this->addToSelection($this->pluckPage());
        } else {
            $this->subtractFromSelection($this->pluckPage());
        }
    }

    public function pluckPage() {
        return $this->rows->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }

    public function pluckAll() {
        return $this->rowsQuery->pluck('id')->map(fn($id) => (string) $id);
    }

    public function selectAll() {
        $this->selectAll = true;
        $this->selectPage = true;
        $this->addToSelection($this->pluckAll());
    }

    public function deselectAll() {
        $this->selectAll = false;
        $this->selectPage = false;
        $this->selected = [];
    }

    public function getSelectedCountProperty() {
        return count($this->selected);
    }
    public function getHasSelectionProperty() {
        return $this->selectedCount > 0;
    }

    public function getSelectedRowsQueryProperty()
    {
        return (clone $this->rowsQuery)
            ->whereKey($this->selected);
    }
}
