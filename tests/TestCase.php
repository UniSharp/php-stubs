<?php

namespace Tests;

use Mockery as m;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function mockUser()
    {
        $user = m::mock(Model::class);
        $user->shouldReceive('getAttribute')
             ->andReturnUsing(function ($key) {
                 return [
                     'name' => 'Albert Seafood',
                 ][$key] ?? null;
             });

        $parser = m::mock(Parser::class);
        $parser->shouldReceive('setRequest')->andReturnSelf();
        $parser->shouldReceive('hasToken')->andReturn(true);

        JWTAuth::shouldReceive('parser')->andReturn($parser);
        JWTAuth::shouldReceive('parseToken->authenticate')->andReturn($user);

        Auth::shouldReceive('user')->andReturn($user);
        Auth::shouldReceive('userResolver')->andReturn(function () {
            //
        });

        return $user;
    }
}
