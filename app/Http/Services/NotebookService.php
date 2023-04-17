<?php

namespace App\Http\Services;

use App\Models\Notebook;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class NotebookService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Notebook::all();
    }

    /**
     * @param int $id
     * @return Notebook|null
     */
    public function getOne(int $id): Notebook|null {
        return Notebook::findOrFail($id);
    }

    /**
     * @param array $body
     * @return mixed
     */
    public function create(array $body): mixed
    {
        return Notebook::create($body);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request): mixed
    {

        $id = $request->input('id');
        $notebook = Notebook::findOrFail($id);

        $notebook->full_name = $request->input('full_name');
        $notebook->company = $request->input('company');
        $notebook->phone = $request->input('phone');
        $notebook->email = $request->input('email');
        $notebook->birth_date = $request->input('birth_date');
        $notebook->image_link = $request->input('image_link');
        $notebook->save();

        return $notebook;
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $notebook = Notebook::findOrFail($id);
        $notebook->delete();
    }
}
