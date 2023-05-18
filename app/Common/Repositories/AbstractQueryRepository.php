<?php

namespace App\Common\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Spatie\FlareClient\Http\Exceptions\NotFound;

Abstract class AbstractQueryRepository
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

    public function firstOrFailed(int $id): mixed
    {
        $model = $this->model->find($id);

        if(empty($model)){
            abort(404);
        }

        return $model;
    }

    public function firstWhere(array $where, array $columns = ['*']): mixed
    {
        $model = $this->model->where($where)->first($columns);

        return $model;
    }

    public function findWhere(array $where, array $columns = ['*']): mixed
    {
        $model = $this->model->where($where)->first($columns);

        return $model;
    }


}
