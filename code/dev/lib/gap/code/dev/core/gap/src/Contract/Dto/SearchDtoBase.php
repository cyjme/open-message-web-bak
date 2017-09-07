<?php
namespace Gap\Contract\Dto;

abstract class SearchDtoBase extends DtoBase
{
    protected $xsSearch;

    public function setXsSearch($xsSearch)
    {
        $this->xsSearch = $xsSearch;
    }
}
