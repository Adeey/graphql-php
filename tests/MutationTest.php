<?php

use PHPUnit\Framework\TestCase;
use MaxGraphQL\Types\Mutation;
use \MaxGraphQL\FieldTypes\Enum;

class MutationTest extends TestCase
{
    public function testMutation()
    {
        $string = 'mutation{testing(id:5,nullarg:null,test:{test2:5}){test3{test4}}}';

        $mutation = new Mutation('testing');
        $mutation
            ->addSelect(['test3' => ['test4']])
            ->addArguments(['id' => 5, 'nullarg' => null, 'test' => ['test2' => 5]]);

        $this->assertSame($string, $mutation->getPreparedQuery());
    }

    public function testMutation2()
    {
        $string = 'mutation{testing(id:{user_id:5,nullarg:null,user_type:"account"},test:{test2:5}){test3{test4}}}';

        $mutation = new Mutation('testing');
        $mutation
            ->addSelect(['test3' => ['test4']])
            ->addArguments(['id' => ['user_id' => 5, 'nullarg' => null, 'user_type' => 'account'], 'test' => ['test2' => 5]]);

        $this->assertSame($string, $mutation->getPreparedQuery());
    }

    public function testMutation3()
    {
        $string = 'mutation{testing(id:{user_id:"5",nullarg:null,user_type:ACCOUNT},test:{test2:5}){test3{test4}}}';

        $mutation = new Mutation('testing');
        $mutation
            ->addSelect(['test3' => ['test4']])
            ->addArguments(['id' => ['user_id' => '5', 'nullarg' => null, 'user_type' => new Enum('ACCOUNT')], 'test' => ['test2' => 5]]);

        $this->assertSame($string, $mutation->getPreparedQuery());
    }
}