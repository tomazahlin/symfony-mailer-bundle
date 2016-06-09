<?php

namespace Ahlin\Mailer\Filter;

interface FilterChainInterface
{
    /**
     * Apply all filters.
     *
     * @param string $body
     * @param \Swift_Message $message
     * @return string
     */
    public function apply($body, \Swift_Message $message);

    /**
     * Adds / registers the filter.
     * 
     * @param FilterInterface $filter
     * @return FilterChainInterface
     */
    public function addFilter(FilterInterface $filter);
}
