<?php

use PHPUnit\Framework\TestCase;
use MaxGraphQL\Types\Query;

class QueryTest extends TestCase
{
    public function testQuery()
    {
        $string = 'query{testing(id:5,test:{test2:5}){test3{test4}}}';

        $query = new Query('testing');
        $query
            ->addSelect(['test3' => ['test4']])
            ->addArguments(['id' => 5, 'test' => ['test2' => 5]]);

        $this->assertSame($string, $query->getPreparedQuery());
    }

    public function testQuery2()
    {
        $string = 'query{testing(id:"5",user_type:ACCOUNT,test:{test2:5}){test3{test4}}}';

        $query = new Query('testing');
        $query
            ->addSelect(['test3' => ['test4']])
            ->addArguments(['id' => '5', 'user_type' => 'ACCOUNT', 'test' => ['test2' => 5]]);

        $this->assertSame($string, $query->getPreparedQuery());
    }
}