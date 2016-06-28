This is Unister Flight Inventory Test Application.

@author Dmitry Tarantin [dimichspb@gmail.com](mailto:dimichspb@gmail.com)

Webroot folder is `web`. The application has been configured to work with Apache web-server as default.

Tests in `codeception` directory are developed with [Codeception PHP Testing Framework](http://codeception.com/).

To run the application please do the following steps:

1. Do to your working directory:

    ```
    cd work
    ```

2. Clone the application repository from github:

    ```
    git clone https://github.com/dimichspb/unister.git
    ```

3. Install dependencies using composer:

    ```
    composer install
    ```

    Please note that composer should be installed in your system

4. Make sure your web-server is configured to open `web` directory as default

5. Create database:

    By default the application is configured to work with MySql DataBase. You can adjust connection settings by changing
    `/config/db.php` file like follows:

    ```
    $dbConfig = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=yii2basic',  // DataBase name
        'username' => 'root', // Username
        'password' => '', // Password
        'charset' => 'utf8',
        'enableSchemaCache' => true,
        'enableQueryCache' => true,
    ];
    ```
6. Run migrations:

    ```
    php yii migrate
    ```

7. You can try to open the application in your favourite browser now!

8.

After creating and setting up the advanced application, follow these steps to prepare for the tests:

1. Install Codeception if it's not yet installed:

   ```
   composer global require "codeception/codeception=2.0.*" "codeception/specify=*" "codeception/verify=*"
   ```

   If you've never used Composer for global packages run `composer global status`. It should output:

   ```
   Changed current directory to <directory>
   ```

   Then add `<directory>/vendor/bin` to you `PATH` environment variable. Now you're able to use `codecept` from command
   line globally.

2. Install faker extension by running the following from template root directory where `composer.json` is:

   ```
   composer require --dev yiisoft/yii2-faker:*
   ```

3. Create `yii2_advanced_tests` database then update it by applying migrations:

   ```
   codeception/bin/yii migrate
   ```

4. In order to be able to run acceptance tests you need to start a webserver. The simplest way is to use PHP built in
   webserver. In the root directory where `common`, `frontend` etc. are execute the following:

   ```
   php -S localhost:8080
   ```

5. Now you can run the tests with the following commands, assuming you are in the `tests/codeception` directory:

   ```
   # frontend tests
   cd frontend
   codecept build
   codecept run

   # backend tests

   cd backend
   codecept build
   codecept run

   # etc.
   ```

  If you already have run `codecept build` for each application, you can skip that step and run all tests by a single `codecept run`.
