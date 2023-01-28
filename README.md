Installation 


Clone the repository

        git clone https://github.com/jgodstime/kippa-assessment.git kippa-assessment

Switch to the repo folder

         cd kippa-assessment

Note: your PHP version should be atleast 8.0

Create db name 

Install all the dependencies using composer

        composer install 

Rename your .env.example file to .env

        cp .env.example .env

Generate a new application key

        php artisan key:generate

Setup your database credentials 


Start the local development server

         php artisan serve  --port=8000

On your browser, enter http://127.0.0.1:8000

