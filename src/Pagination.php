<?php

namespace Viloveul\Support;

use Closure;
use InvalidArgumentException;

class Pagination
{
    /**
     * @var string
     */
    protected $baseUrl = '/api';

    /**
     * @var array
     */
    protected $conditions = [];

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var mixed
     */
    protected $orderBy;

    /**
     * @var int
     */
    protected $pageSize = 10;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var string
     */
    protected $searchName = 'search';

    /**
     * @var string
     */
    protected $sortOrder = 'DESC';

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * @param $name
     * @param array   $params
     */
    public function __construct($name, array $params = [])
    {
        $this->params = $params;
        $this->setSearchName($name);
        if (array_key_exists('page', $params)) {
            $this->setCurrentPage($params['page']);
        }
        if (array_key_exists('size', $params)) {
            $this->setPageSize($params['size']);
        }
        if (array_key_exists('order', $params)) {
            $this->setOrderBy($params['order']);
        }
        if (array_key_exists('sort', $params)) {
            $this->setSortOrder($params['sort']);
        }
    }

    /**
     * @param  $default
     * @return mixed
     */
    public function getBaseUrl($default = '/')
    {
        return $this->baseUrl ?: $default;
    }

    /**
     * @param  $default
     * @return mixed
     */
    public function getCurrentPage($default = 1)
    {
        return $this->currentPage ?: abs($default);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param  $default
     * @return mixed
     */
    public function getOrderBy($default = 'id')
    {
        return $this->orderBy ?: $default;
    }

    /**
     * @param  $default
     * @return mixed
     */
    public function getPageSize($default = 10)
    {
        return $this->pageSize ?: abs($default);
    }

    /**
     * @param  $default
     * @return mixed
     */
    public function getSearchName($default = 'search')
    {
        return $this->searchName ?: $default;
    }

    /**
     * @param $default
     */
    public function getSortOrder($default = 'ASC')
    {
        return strtoupper($this->sortOrder ?: $default);
    }

    public function getTotal()
    {
        return abs($this->total);
    }

    /**
     * @param Closure $handler
     */
    public function prepare(Closure $handler)
    {
        if (array_key_exists($this->searchName, $this->params) && is_array($this->params[$this->searchName])) {
            $this->conditions = (array) $this->params;
        } else {
            foreach ($this->params as $key => $value) {
                if (is_scalar($value) && 0 === stripos($key, $this->searchName . '_') && $key !== ($this->searchName . '_')) {
                    $this->conditions[$key] = $value;
                }
            }
        }
        call_user_func($handler, $this, $this->conditions);
    }

    public function results()
    {
        return [
            'links' => [
                'self' => $this->buildUrl($this->getCurrentPage()),
                'prev' => $this->getCurrentPage() > 1 ? $this->buildUrl($this->getCurrentPage() - 1) : null,
                'next' => ($this->getCurrentPage() * $this->getPageSize()) < $this->getTotal() ? $this->buildUrl($this->getCurrentPage() + 1) : null,
                'first' => $this->buildUrl(1),
                'last' => $this->buildUrl(ceil($this->getTotal() / $this->getPageSize())),
            ],
            'data' => $this->data,
        ];
    }

    /**
     * @param $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param  $page
     * @return mixed
     */
    public function setCurrentPage($page)
    {
        if ($page !== null) {
            if (is_array($page)) {
                if (!array_key_exists('current', $page)) {
                    throw new InvalidArgumentException("Argument must have index 'current' if array.");
                }
                $this->currentPage = abs($page['current']) ?: 1;
                if (array_key_exists('size', $page)) {
                    $this->setLimit($page['size']);
                }
            } elseif (is_scalar($page)) {
                $this->currentPage = abs($page) ?: 1;
            } else {
                throw new InvalidArgumentException("Argument must type of array or number.");
            }
        }
        return $this;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @param $pageSize
     */
    public function setPageSize($pageSize)
    {
        if ($pageSize !== null) {
            $this->pageSize = abs($pageSize) ?: 10;
        }
    }

    /**
     * @param $searchName
     */
    public function setSearchName($searchName)
    {
        $this->searchName = $searchName;
    }

    /**
     * @param $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @param $total
     */
    public function setTotal($total)
    {
        $this->total = abs($total);
    }

    /**
     * @param  $page
     * @return mixed
     */
    protected function buildUrl($page)
    {
        $base = $this->getBaseUrl();
        $selfParams = array_replace_recursive($this->params, [
            'page' => abs($page),
            'size' => $this->getPageSize(),
        ]);
        return $base . '?' . http_build_query($selfParams);
    }
}
