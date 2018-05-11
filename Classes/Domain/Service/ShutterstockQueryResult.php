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
    protected $assets;

    /**
     * @var int
     */
    protected $numberOfAssets;


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
        if (!is_array($this->assets)) {
            $result = $this->query->getResult();
            $this->assets = $result['data'];
            $this->numberOfAssets = $this->query->count();
        }
    }

    /**
     * Returns a clone of the query object
     *
     * @return ShutterstockQuery
     * @api
     */
    public function getQuery()
    {
        return clone $this->query;
    }

    public function current()
    {
        $this->initialize();
        return current($this->assets);
    }

    public function next()
    {
        $this->initialize();
        next($this->assets);
    }

    public function key()
    {
        $this->initialize();
        key($this->assets);
    }

    public function valid()
    {
        $this->initialize();
        return current($this->assets) !== false;
    }

    public function rewind()
    {
        $this->initialize();
        reset($this->assets);
    }

    public function offsetExists($offset)
    {
        $this->initialize();
        return isset($this->queryResult[$offset]);
    }

    public function offsetGet($offset)
    {
        $this->initialize();
        return isset($this->queryResult[$offset]) ? $this->assets[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->initialize();
        $this->assets[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        $this->initialize();
        unset($this->assets[$offset]);
    }

    public function count()
    {
        $this->initialize();
        return $this->numberOfAssets;
    }
}
