<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'testing');
        config()->set('database.connections.testing.database', 'library_management_test');
    }

    public function test_get_authors(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data author
        $this->artisan('db:seed --class=AuthorSeeder');

        $response = $this->get('api/authors');
        $responseData = $this->getResponseData($response);
        $expectedResponse = $this->getExpectedResponse('author_list.json');

        $response->assertStatus(200);
        $this->assertEquals($responseData, $expectedResponse);
    }

    public function test_author_not_found(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // call api wrong id
        $response = $this->get('api/authors/1');
        $responseData = $this->getResponseData($response);

        $response->assertStatus(404);
        $this->assertEquals($responseData, ['message' => 'Author not found']);
    }

    public function test_get_author_by_id(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data author
        $this->artisan('db:seed --class=AuthorSeeder');

        // create data book
        $this->artisan('db:seed --class=BookSeeder');

        $response = $this->get('api/authors/a1c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f');
        $responseData = $this->getResponseData($response);
        $expectedResponse = $this->getExpectedResponse('author_by_id.json');

        $response->assertStatus(200);
        $this->assertEquals($responseData, $expectedResponse);
    }

    public function test_author_create(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        $data = [
            'id' => '90d873fc-8a32-48ce-978f-4bc303e47444',
            'name' => 'Test',
            'bio' => 'Test bio',
            'birth_date' => '2024-08-25',
        ];

        $response = $this->post('api/authors', $data);
        $responseData = $this->getResponseData($response);

        $response->assertStatus(201);
        $this->assertEquals($responseData, ['message' => 'Created successfully']);
    }

    public function test_author_update(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data author
        $this->artisan('db:seed --class=AuthorSeeder');

        // call api to update data
        $response = $this->put('api/authors/a1c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f', [
            'name' => 'Test update',
            'bio' => 'Test bio update',
            'birth_date' => '2024-08-26',
        ]);
        $responseData = $this->getResponseData($response);

        $response->assertStatus(200);
        $this->assertEquals($responseData, ['message' => 'Updated successfully']);
    }

    public function test_author_delete(): void
    {
        // refresh database
        $this->artisan('migrate:fresh');

        // create data author
        $this->artisan('db:seed --class=AuthorSeeder');

        // delete data author after running test_author_create
        $response = $this->delete('api/authors/a1c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f');
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
        return json_decode(file_get_contents(__DIR__ . '/responses/authors/' . $file), true);
    }
}
