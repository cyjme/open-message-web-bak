<?php
namespace Gap\Search\Xs;

use XSSearch;

class DataSet
{
    protected $dtoClass;
    protected $xsSearch;
    protected $currentPage = 1;
    protected $countPerPage = 10;
    protected $pageCount;
    protected $docs;
    protected $itemCount;

    public function __construct(XSSearch $xsSearch, $dtoClass = '')
    {
        $this->xsSearch = $xsSearch;
        $this->dtoClass = $dtoClass;
    }

    public function setCountPerPage($count)
    {
        $this->countPerPage = $count;
        return $this;
    }

    public function getItems()
    {
        $docs = $this->search();
        $items = [];
        $class = $this->dtoClass;

        foreach ($docs as $doc) {
            /*
            foreach (array_keys($doc->getFields()) as $k) {
                 $item[$k] = $this->xsSearch->highlight($doc->$k);
            }
             */
            $item = new $class($doc);
            $item->setXsSearch($this->xsSearch);
            $items[] = $item;
        }
        return $items;
    }

    public function highlight($text)
    {
        return $this->xsSearch->highlight($text);
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

        return $this->itemCount = $this->xsSearch->getLastCount();
    }

    public function getPageCount()
    {
        if ($this->pageCount) {
            return $this->pageCount;
        }

        $this->pageCount = ceil($this->getItemCount() / $this->countPerPage);
        return $this->pageCount;
    }

    protected function search()
    {
        if ($this->docs) {
            return $this->docs;
        }

        $this->xsSearch->setLimit(
            $this->countPerPage,
            ($this->getCurrentPage() - 1) * $this->countPerPage
        );
        $this->docs = $this->xsSearch->search();

        return $this->docs;
    }
}
