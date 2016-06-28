#This is Unister Flight Inventory Test Application.

@author Dmitry Tarantin [dimichspb@gmail.com](mailto:dimichspb@gmail.com)

Webroot folder is `web`. The application has been configured to work with Apache web-server as default.

Tests in `codeception` directory are developed with [Codeception PHP Testing Framework](http://codeception.com/).

##To run the application please do the following steps:

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

7. You can try to open the application in your favourite browser now.

8. Enjoy!

##After creating and setting up the application, follow these steps to work with it:

1. Please use the following details to login:

    ###Admin role:
    ```
    admin/admin
    ```

    ###Manager role:
    ```
    manager/manager
    ```

    ###Customer role:
    ```
    customer/customer
    ```

2. To navigate lease use top nav bar.

##To run unit tests:

1. Make sure you have `codeception` testing framework installed in your system:

    ```
    composer global require "codeception/codeception=2.0.*" "codeception/specify=*" "codeception/verify=*"
    ```

   If you've never used Composer for global packages run `composer global status`. It should output:

   ```
   Changed current directory to <directory>
   ```

   Then add `<directory>/vendor/bin` to you `PATH` environment variable. Now you're able to use `codecept` from command
   line globally.


2. Please go to the `/tests` directory.

3. Run `codecept build`.

4. Run `codecept run unit`.

5. Make sure all the tests are finished with no failures.
