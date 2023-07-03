<?php

namespace App\Application\Traits;

Trait Pagination
{
    protected bool $paginatable = false;

    protected bool $perPageValue;

    public function checkRequestNeedPaginationData(): void
    {
        if ($this->has('page')) {
            $this->paginatable = true;
            $this->perPageValue = $this->getPerPageValue();
        } else {
            $this->paginatable = false;
        }
    }

    public function getPerPageValue(): ?int
    {
        if($this->paginatable && $this->has('perPage') && filter_var($this->get('perPage'), FILTER_VALIDATE_INT) === true){
            return $this->get('perPage');
        }

        return null;
    }


}
