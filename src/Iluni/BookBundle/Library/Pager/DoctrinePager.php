<?php
// Modified version of Ideato\SimplePagerBundle\Pagination\Pager

namespace Iluni\BookBundle\Library\Pager;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Iluni\BookBundle\Library\Pager\sfPager;

class DoctrinePager extends sfPager
{
    private $query_class = 'Doctrine\ORM\AbstractQuery';

    private $query = null;

    /**
     * Clone the query and then sets all the needed parameters
     *
     * @return mixed returns and object of class $query_class (default: Doctrine\ORM\AbstractQuery )
     */
    protected function cloneQuery()
    {
        $q = clone $this->query;
        return $q;
    }

    /**
     * Before setting the query, checks if the given object is of class $query_class.
     *
     * @throw InvalidArgumentException
     * @param query_class $query
     */
    public function setQuery($query)
    {
        if (!$query instanceof  $this->query_class) {
            $message = 'The given query is not an instance of '.
                $this->query_class.',  but '.  \get_class($query);
            throw new \InvalidArgumentException($message);
        }
        $this->query = $query;

        return $this; // implement fluent interface;
    }


    public function getQuery()
    {
        return $this->query;
    }

    /**
     * 1. Checks if the query has been set.
     * 2. Retrieves the actual page resutls
     * 3. Sets the results total number
     * 4. Calculate and sets the last page
     */
    public function init()
    {
        if ($this->query === null) {
            throw new \Exception('You must specify a query');
        }

        $paginator = $this->getResults();
        $nb_results = $paginator->count();

        $this->setNbResults($nb_results);
        $this->setLastPage(ceil($this->nbResults / $this->maxPerPage));

        return $this; // implement fluent interface;
    }

    /**
     * Returns an array of results on the given page.
     *
     * @return array
     */
    public function getResults()
    {
        if ($this->results !== null) {
            return $this->results;
        }

        // Potential Hydration Modes
        // --------------------------------
        // Doctrine\ORM\Query::HYDRATE_OBJECT
        // Doctrine\ORM\Query::HYDRATE_ARRAY
        // Doctrine\ORM\Query::HYDRATE_SCALAR
        // Doctrine\ORM\Query::HYDRATE_SINGLE_SCALAR
        // Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT

        // Hydrate the result as an array to get the requested format
        // When you use array hyrdation doctrine does it according
        // to your entity graph

        $this->query
            // ->setHydrationMode(...)
            ->setFirstResult($this->getFirstIndice() - 1)
            ->setMaxResults($this->getMaxPerPage());

        $paginator = new Paginator($this->query, $fetchJoinCollection = true);
        $this->results = $paginator;

        return $this->results;
    }

    /**
     * Returns an object at a certain offset.
     *
     * Used internally by {@link getCurrent()}.
     *
     * @return mixed
     */
    protected function retrieveObject($offset)
    {
        return $this->results[$offset - $this->getFirstIndice()];
    }
}

