<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get($with = [])
    {
        if (count($with) > 0) {
            return $this->model->with($with)->get();
        }

        return $this->model->get();
    }

    public function create(array $attributes)
    {
        if (isset($attributes['_token'])) {
            unset($attributes['_token']);
        }

        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $record = $this->find($id);

        if (isset($attributes['_token'])) {
            unset($attributes['_token']);
        }

        if ($record) {
            $record->update($attributes);
            return $record;
        }

        return false;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->delete();
        }

        return false;
    }
}
