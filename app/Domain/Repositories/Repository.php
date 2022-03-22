<?php
namespace App\Domain\Repositories;

use  \App\Domain\InterFaces\RepositoryInterface;
use Illuminate\Support\Str;

abstract class Repository implements RepositoryInterface
{



    public function getAll()
    {
        return $this->model->all();
    }
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }
    public function update($id, array $attributes)
    {
        $record = $this->getById($id);
        $record->update($attributes);

        return $record;
    }
    public function delete($id)
    {
        return $this->getById($id)->delete();
    }

}
