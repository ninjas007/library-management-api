<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    private $bookRepository;
    private $authorRepository;

    public function __construct()
    {
        $this->bookRepository = app(\App\Repositories\BookRepository::class);
        $this->authorRepository = app(\App\Repositories\AuthorRepository::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->resJson([
                'data' => $this->bookRepository->get(['author'])
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
            $author = $this->authorRepository->find($request->author_id);

            if (is_null($author)) {
                return $this->resJson([
                    'message' => 'Author not found'
                ], 404);
            }

            $this->bookRepository->create($request->all());

            return $this->resJson([
                'message' => 'Created successfully',
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
            $book = $this->bookRepository->find($id);

            if (is_null($book)) {
                return response()->json([
                    'message' => 'Book not found',
                ], 404);
            }

            return $this->resJson([
                'data' => $book->load('author'),
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
            $author = $this->authorRepository->find($request->author_id);

            if (is_null($author)) {
                return $this->resJson([
                    'message' => 'Author not found'
                ], 404);
            }

            $this->bookRepository->update($id, $request->all());

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
            $book = $this->bookRepository->delete($id);

            if (!$book) {
                return $this->resJson([
                    'message' => 'Book not found'
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
            'title' => 'required',
            'description' => 'required',
            'publish_date' => 'required|date',
            'author_id' => 'required'
        ], [
            'title.required' => 'Name is required',
            'description.required' => 'Description is required',
            'publish_date.required' => 'Publish date is required',
            'publish_date.date' => 'Publish date must be a valid date with format: Y-m-d',
            'author_id.required' => 'Author is required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return [];
    }
}
