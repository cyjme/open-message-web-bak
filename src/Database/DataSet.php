<?php
namespace Gap\Database;

use Gap\Contract\Database\SqlBuilder\SelectSqlBuilderInterface;

class DataSet implements \JsonSerializable
{
    protected $ssb;
    protected $dtoClass;

    protected $currentPage;
    protected $itemCount;
    protected $pageCount;
    protected $countPerPage = 10;

    public function __construct(SelectSqlBuilderInterface $ssb, $dtoClass = '')
    {
        $this->ssb = $ssb;
        $this->dtoClass = $dtoClass;
    }

    public function setCountPerPage($count)
    {
        $this->countPerPage = $count;
        return $this;
    }

    public function getItems()
    {
        $this->ssb
            ->limit($this->countPerPage)
            ->offset(($this->getCurrentPage() - 1) * $this->countPerPage);

        if ($this->dtoClass) {
            return $this->ssb->listDto($this->dtoClass);
        }

        return $this->ssb->listObj();
    }

    public function setCurrentPage($page)
    {
        $page = ($page > 1) ? $page : 1;
        $this->currentPage = $page;
        return $this;
    }

    public function getCurrentPage()
    {
        if ($this->currentPage) {
            return $this->currentPage;
        }

        $this->setCurrentPage(1);
        return $this->currentPage;
    }

    public function getItemCount()
    {
        if ($this->itemCount) {
            return $this->itemCount;
        }

        return $this->ssb->count();
    }

    public function getPageCount()
    {
        if ($this->pageCount) {
            return $this->pageCount;
        }

        $this->pageCount = ceil($this->getItemCount() / $this->countPerPage);
        return $this->pageCount;
    }

    public function jsonSerialize()
    {
        $arr = [];
        foreach ($this->getItems() as $item) {
            $arr[] = $item;
        }

        return $arr;
    }
}
