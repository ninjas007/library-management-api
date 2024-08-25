<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'testing');
        config()->set('database.connections.testing.database', 'library_management_test');
    }

    public function test_get_books(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data author
        $this->artisan('db:seed --class=AuthorSeeder');

        // create data book
        $this->artisan('db:seed --class=BookSeeder');

        $response = $this->get('api/books');
        $responseData = $this->getResponseData($response);
        $expectedResponse = $this->getExpectedResponse('book_list.json');

        $response->assertStatus(200);
        $this->assertEquals($responseData, $expectedResponse);
    }

    public function test_book_not_found(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // call api wrong id
        $response = $this->get('api/books/1');
        $responseData = $this->getResponseData($response);

        $response->assertStatus(404);
        $this->assertEquals($responseData, ['message' => 'Book not found']);
    }

    public function test_get_book_by_id(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data author
        $this->artisan('db:seed --class=AuthorSeeder');

        // create data book
        $this->artisan('db:seed --class=BookSeeder');

        $response = $this->get('api/books/abc7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f');
        $responseData = $this->getResponseData($response);
        $expectedResponse = $this->getExpectedResponse('book_by_id.json');

        $response->assertStatus(200);
        $this->assertEquals($responseData, $expectedResponse);
    }

    public function test_book_create(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create author
        $this->artisan('db:seed --class=AuthorSeeder');

        $data = [
            'id' => 'abc7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
            'title' => 'Test title',
            'description' => 'Test description',
            'publish_date' => '2024-08-25',
            'author_id' => 'a1c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
        ];

        $response = $this->post('api/books', $data);
        $responseData = $this->getResponseData($response);

        $response->assertStatus(201);
        $this->assertEquals($responseData, ['message' => 'Created successfully']);
    }

    public function test_book_update(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data author
        $this->artisan('db:seed --class=AuthorSeeder');

        // create data Book
        $this->artisan('db:seed --class=BookSeeder');

        // call api to update data
        $response = $this->put('api/books/abc7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f', [
            'title' => 'Test title',
            'description' => 'Test description',
            'publish_date' => '2024-08-25',
            'author_id' => 'a1c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
        ]);
        $responseData = $this->getResponseData($response);


        $response->assertStatus(200);
        $this->assertEquals($responseData, ['message' => 'Updated successfully']);
    }

    public function test_book_delete(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data Book
        $this->artisan('db:seed --class=BookSeeder');

        // delete data Book after running test_book_create
        $response = $this->delete('api/books/abc7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f');
        $responseData = $this->getResponseData($response);

        $response->assertStatus(200);
        $this->assertEquals($responseData, ['message' => 'Deleted successfully']);
    }

    private function getResponseData($response)
    {
        return json_decode($response->getContent(), true);
    }

    private function getExpectedResponse($file)
    {
        return json_decode(file_get_contents(__DIR__ . '/responses/books/' . $file), true);
    }
}
