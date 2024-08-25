## Requirements

- PHP 8.0 or higher
- Composer 2.0 or higher
- MySQL 8.0 or higher


## Run Project

- Clone project
- Run `composer install`
- Copy `.env.example` to `.env`
- Create database and setting in file `.env`
- Run `php artisan key:generate`
- Run `php artisan migrate`
- Running project using `php artisan serve` or something you like
- Open the project

## List API
- Books
```
- GET /api/books - List all books
- GET /api/books/{id} - Get book by id
- POST /api/books - Create new book
- PUT /api/books/{id} - Update book
- DELETE /api/books/{id} - Delete book
```

- Authors
```
- GET /api/authors - List all authors
- GET /api/authors/{id} - Get author by id
- POST /api/authors - Create new author
- PUT /api/authors/{id} - Update author
- DELETE /api/authors/{id} - Delete author
```


## Run Unit Testing
- Copy `.env.example` to `.env.testing`
- Create database library_management_test or something you like
- Run `php artisan test` to all tests
- To specific test u can using filter. Example: `php artisan test --filter=BookTest`.

## Write-up
<!-- get link -->
[![Write-up]](https://github.com/ninjas007/library-management/blob/main/Writeup.docx)
