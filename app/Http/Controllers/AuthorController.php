<?php

namespace App\Http\Controllers;

use App\Repositories\AuthorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->resJson([
                'data' => $this->authorRepository->get()
            ]);
        } catch (\Exception $e) {
            return $this->resFailJson($e);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $this->validateRequest($request);

        if (!empty($validate)) {
            return $this->resJson(['data' => $validate, 'message' => 'Validation failed'], 422);
        }

        try {
            $this->authorRepository->create($request->all());

            return $this->resJson([
                'message' => 'Created successfully'
            ], 201);
        } catch (\Exception $e) {
            return $this->resFailJson($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $author = $this->authorRepository->find($id);

            if (is_null($author)) {
                return $this->resJson([
                    'message' => 'Author not found'
                ], 404);
            }

            return $this->resJson([
                'data' => $author->load('books'),
            ]);
        } catch (\Exception $e) {
            return $this->resFailJson($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $this->validateRequest($request);

        if (!empty($validate)) {
            return $this->resJson(['data' => $validate, 'message' => 'Validation failed'], 422);
        }

        try {
            $author = $this->authorRepository->update($id, $request->all());

            if (!$author) {
                return $this->resJson([
                    'message' => 'Author not found'
                ], 404);
            }

            return $this->resJson([
                'message' => 'Updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->resFailJson($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $author = $this->authorRepository->delete($id);

            if (!$author) {
                return $this->resJson([
                    'message' => 'Author not found'
                ], 404);
            }

            return $this->resJson([
                'message' => 'Deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->resFailJson($e);
        }
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'birth_date' => 'required|date',
        ], [
            'name.required' => 'Name is required',
            'birth_date.required' => 'Birth date is required',
            'birth_date.date' => 'Birth date must be a valid date with format: Y-m-d',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return [];
    }
}
