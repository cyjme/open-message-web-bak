<?php
namespace Gap\Contract\Dto;

trait SearchDtoTrait
{
    protected $xsSearch;

    public function setXsSearch($xsSearch)
    {
        $this->xsSearch = $xsSearch;
    }
}
