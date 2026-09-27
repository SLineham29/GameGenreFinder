# Game Genre Finder

As someone who likes to play games from a wide variety of genres and on a wide variety of consoles/platforms,
it can be very easy to miss games that are either quite niche, or multiple years old so they are less discussed.

As an example, I really enjoy playing point-and-click games on PC, but because the genre has greatly decreased in
popularity over the years then it's hard to find details and discussions on games in the genre beyond "the classics".

This web app uses the [IGDB API](https://www.igdb.com/api) to get a list of every available genre and platform,
then allow the user to filter through both to find a game that they might enjoy looking further into and playing.

<img width="100%" height="auto" alt="Screenshot of the home page with a chosen game." src="https://github.com/user-attachments/assets/9079f4bb-a962-4ba1-944e-6fefe64086b8" />


## How to Run

1) Clone this repository.

2) Install Laravel Herd [at this link](https://herd.laravel.com/windows), it automatically downloads and pre-configures PHP and Node.js.

3) Open a command prompt on the repository and run the following commands line by line:

    1) Install the prerequisite libraries.
    ```
    composer install
    ```
    ```
    npm install
    ```

    2) Make a new database file with the default tables. Enter 'yes' when prompted.
   ```
   php artisan migrate
   ```
   
    3) Create the `.env` by copying `.env.example`
   ```
   copy .env.example .env
   ```
   
    4) Make a new application key for the `.env`
    ```
    php artisan key:generate
     ```

> [!WARNING]
> For this website to work, you'll need to get a free IGDB client ID and secret by [following this guide](https://api-docs.igdb.com/#account-creation).
> You will then need to add them to the following 2 lines in the `.env` file, replacing the blank values with your own ID and secret.
> ```
> IGDB_CLIENT_ID=IdGoesHere
> IGDB_CLIENT_SECRET=SecretGoesHere
> ```

4) Run the server using the following command in the repository:
```
php artisan dev
```

## How to Use

1) Select at least one genre from the row of three select boxes.

2) Select the platform you want the game be on.

3) Click the "Search for Game" button.

4) Look through the details of the resultant game.

> [!IMPORTANT]
> If you get a `Warning: PHP Request Startup: POST data can't be buffered; all data discarded in Unknown on line 0`
> error when searching for a game, you will need to go to PHP.ini your PHP install (usually in `C:\Users\*User*\.config\herd\bin`),
> then uncomment and change the `sys_temp_dir` directory to a folder anywhere on your PC. For example:
> ```
> sys_temp_dir = "C:\Users\samuel\.config\herd\bin\php85\tmp"
> ```

## Further Improvements

I have a number of ideas of things I could work on in this project given more time, these include:

- Marking a game as "seen/played" so it won't appear again from the search.
- Adding more information about a game by making more API calls, such as using game_time_to_beat to display how many hours it might take to beat the chosen game.
- Adding an optional method to display every single game found by the games API endpoint to let the user decide which of the games they like the look of.
- Adding tests to ensure the API outputs are valid and check if the error handling is working as expected.
