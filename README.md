# Laravel AI Semantic Search

This Laravel web application enables users to perform semantic searches using natural language queries. It uses OpenAI's text-embedding-3-small model to create vector embeddings for categories stored in a database and compares them with query embeddings using cosine similarity.

## Features

- Upload category data from an Excel file
- Generate AI embeddings using OpenAI API
- Perform semantic search using cosine similarity
- Display top-matching category with similarity score
- Input field retains its value after search

## Setup Instructions

1. Clone the repository  
   git clone https://github.com/HitShah25/laravel-ai-semantic-search.git  
   cd laravel-ai-semantic-search

2. Install PHP dependencies  
   composer install

3. Copy the environment configuration  
   cp .env.example .env

4. Generate the application key  
   php artisan key:generate

5. Configure environment variables in .env  
   DB_DATABASE=your_database_name  
   DB_USERNAME=your_database_username  
   DB_PASSWORD=your_database_password  
   OPENAI_API_KEY=your_openai_api_key

6. Run database migrations  
   php artisan migrate

7. Place your Excel file (e.g., categories.xlsx) in storage/app/public/

8. Import categories from the Excel file  
   php artisan import:categories storage/app/public/categories.xlsx

9. Generate vector embeddings for the imported categories  
   php artisan generate:category-embeddings

10. Start the local development server  
    php artisan serve

11. Visit the application  
    Open http://127.0.0.1:8000 in your browser to use the semantic search interface.

