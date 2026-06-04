<?php

namespace App\Services;

use App\Repositories\BaseRepository;

class BaseService
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    public function bulkDestroy(array $ids)
    {
        return $this->repository->bulkDelete($ids);
    }
}
