# Weather Metrics

CLI application that allows searching for locations, pulling it's cordinates from OpenWeather Geocoder, Pulling weather data of the selected cities from OneCall API 3.0 using locations' cordinates, then push the weather data of the locations to Whatagraph.

## Server Requirements

-   PHP >= 8.0
-   BCMath PHP Extension
-   Ctype PHP Extension
-   cURL PHP Extension
-   DOM PHP Extension
-   Fileinfo PHP Extension
-   JSON PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PCRE PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension
- composer >= 2.0

## Installtion

- Clone the repo
  
  ``` 
  git clone https://github.com/maboulfotouh/weather-metrics.git 
  ```
- Move to repo's directory
  ``` 
  cd weather-metrics 
  ```
- Install depdenceies
  ``` 
  composer install 
  ```
- Copy .env.example to .env file
  ``` 
  cp .env.example .env 
  ```
- Add the following variables to your `.env` file
  ```
  OPENWEATHER_API_KEY
  WG_ACCESS_TOKEN
  ```
  You can get `OPENWEATHER_API_KEY` from https://openweathermap.org/api
  And `WG_ACCESS_TOKEN` from whatagraph.com

- Generate `APP_KEY`
  ``` php artisan key:generate```
- Cache the new variables
  ``` 
  php artisan config:cache
   ```
- Create Whatagraph mertics and diemnsion
  ``` 
  php artisan WG:create-structure
   ```
- Start using the CLI!
  ``` 
  php artisan weather:pull-and-push-to-whatagraph
   ```

## How it works

Adapter pattern is used for integrating OpenWeather Geocoder & OneCall API 3.0
Each of them is using an adapter which is implementing it's own interface, Then in the services the interface is used for adding more decoupling between the app layer and implementation layer.
Also, for the ease of changing any of the adapters if we decieded to move to another third party at any point of time.

The adapters are binded to its interface in `AppServiceProvider`

<hr>
Before using the application we must create the required metrics and dimensions at Whatagraph, in order to be able to push the weather data.

The required metrics and dimensions are declared in `whatagraph.php` config file,
And the following command is responsible for creating them if they're not created.
``` 
php artisan WG:create-structure
 ```

<hr>

The application can be used through the CLI by using the following command
``` 
php artisan weather:pull-and-push-to-whatagraph
 ```

Here's an example of CLI

![CLI Example](https://i.ibb.co/NrY4CLn/Screen-Shot-2023-02-06-at-7-19-44-AM.png "CLI Example")
