<?php

namespace App\Common\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

Abstract class AbstractCommandRepository
{
    protected Application $app;
    protected Model $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    public function getModel()
    {
        return $this->model;
    }

    abstract public function model();

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function create(array $attributes): mixed
    {
        $model = $this->model->newInstance();
        $model->forceFill($attributes);
        $model->save();
        return $model;
    }

    public function update(array $attributes, int $id): mixed
    {
        $model = $this->model->find($id);
        $model->forceFill($attributes);
        $model->save();
        return $model;
    }

    public function delete(int $id): void
    {
        $this->model->find($id)->delete();
    }
}
