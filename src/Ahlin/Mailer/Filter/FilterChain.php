<?php

namespace Ahlin\Mailer\Filter;

/**
 * FilterChain contains all registered (tagged) filters and can apply all of them.
 */
class FilterChain implements FilterChainInterface
{
    /**
     * @var array|FilterInterface[]
     */
    private $filters;

    /**
     * FilterChain constructor.
     */
    public function __construct()
    {
        $this->filters = array();
    }
    
    /**
     * Apply all filters.
     *
     * @param string $body
     * @param \Swift_Message $message
     * @return string
     */
    public function apply($body, \Swift_Message $message)
    {
        // Each filter will be applied on the body
        
        foreach ($this->filters as $filter) {
            $body = $filter->apply($body, $message);
        }
        
        return $body;
    }

    /**
     * Adds / registers the filter.
     *
     * @param FilterInterface $filter
     * @return FilterChainInterface
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
        
        return $this;
    }
}
