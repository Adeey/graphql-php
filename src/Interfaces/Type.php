<?php

namespace MaxGraphQL\Interfaces;

interface Type
{
    /**
     * Set name of query
     * @param string $name
     */
    public function __construct($name);

    /**
     * Build query and return string
     * @return string
     */
    public function __toString();

    /**
     * Add select to query
     * @param  array|string $field
     * @return self
     */
    public function addSelect($field);

    /**
     * Add arguments to query
     * @param array|string $arguments
     * @return self
     */
    public function addArguments($arguments);

    /**
     * Statically build query string
     * @param string $name
     * @param string|array $select
     * @param array $arguments
     * @return mixed
     */
    public static function getPreparedQueryFrom($name, $select, $arguments = []);

    /**
     * Build query string
     * @return string
     */
    public function getPreparedQuery();

    /**
     * Get all selects
     * @return array
     */
    public function getSelect();

    /**
     * Get all arguments
     * @return array
     */
    public function getArguments();

    /**
     * Get type of query(Query or Mutation)
     * @return string
     */
    public function getType();

    /**
     * Get name of query
     * @return string
     */
    public function getName();
}