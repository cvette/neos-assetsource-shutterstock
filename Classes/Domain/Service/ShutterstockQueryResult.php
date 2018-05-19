<?php

namespace Vette\Shutterstock\Domain\Service;

/**
 * A lazy result list that is returned by ShutterstockQuery::execute()
 */
class ShutterstockQueryResult implements \Countable, \Iterator, \ArrayAccess
{

    /**
     * @var ShutterstockQuery
     */
    protected $query;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $totalCount;


    /**
     * ShutterstockQueryResult constructor.
     *
     * @param ShutterstockQuery $query
     */
    public function __construct(ShutterstockQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Loads the objects this QueryResult is supposed to hold
     *
     * @return void
     */
    protected function initialize()
    {
        if (!is_array($this->data)) {
            $result = $this->query->getResult();
            $this->data = $result->getData();
            $this->totalCount = $result->getTotalCount();
        }
    }

    /**
     * Returns a clone of the query object
     *
     * @return ShutterstockQuery
     */
    public function getQuery()
    {
        return clone $this->query;
    }

    public function current()
    {
        $this->initialize();
        return current($this->data);
    }

    public function next()
    {
        $this->initialize();
        next($this->data);
    }

    public function key()
    {
        $this->initialize();
        key($this->data);
    }

    public function valid()
    {
        $this->initialize();
        return current($this->data) !== false;
    }

    public function rewind()
    {
        $this->initialize();
        reset($this->data);
    }

    public function offsetExists($offset)
    {
        $this->initialize();
        return isset($this->queryResult[$offset]);
    }

    public function offsetGet($offset)
    {
        $this->initialize();
        return isset($this->queryResult[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->initialize();
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        $this->initialize();
        unset($this->data[$offset]);
    }

    public function count()
    {
        $this->initialize();
        return $this->totalCount;
    }
}
