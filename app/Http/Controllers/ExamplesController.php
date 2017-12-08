<?php

namespace App\Http\Controllers;

use App\Example;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExampleRequest;
use App\Http\Requests\UpdateExampleRequest;

class ExamplesController
{
    public function index(Request $request)
    {
        return Example::all();
    }

    public function create(StoreExampleRequest $request)
    {
        $example = Example::create($request->all());

        return ['id' => $example->id];
    }

    public function show(Example $example)
    {
        return $example;
    }

    public function update(UpdateExampleRequest $request, Example $example)
    {
        $example->update($request->all());

        return ['success' => true];
    }

    public function destroy(Example $example)
    {
        $example->delete();

        return ['success' => true];
    }
}
