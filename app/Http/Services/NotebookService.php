<?php

namespace App\Http\Services;

use App\Models\Notebook;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface NotebookService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $id
     * @return Notebook|null
     */
    public function getOne(int $id): Notebook|null;

    /**
     * @param array $body
     * @return mixed
     */
    public function create(array $body): mixed;

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request): mixed;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}
