# Movie Library Web Application

## Introduction

This project is a movie library web application developed using PHP and MySQL. The application allows users to sign up, log in, search for movies using the OMDB API, create movie lists (similar to YouTube playlists), and manage these lists as either public or private. The user interface is designed to provide a seamless and visually appealing experience.

## Tech Stack 
The whole project is build through the LAMP stack.
the backend is build using PHP and Mysql 

## Features

### User Authentication

- Users can sign up and log in to the application.
- Session management to ensure user-specific content.

### Home Screen

- After logging in, users are navigated to the home screen.
- The home screen includes a search option to search for movies and view their details.

### Movie Lists

- Users can create lists of movies by adding movies to lists.
- Users' movie lists are displayed on the home page.
- Lists can be public (accessible via a link) or private (only the creator can see them).

### Movie Search

- Integrated with the OMDB API to fetch movie details based on user queries.


## Prerequisites

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Composer (for dependency management)
- Web server (e.g., Apache, Nginx)

## Installation

1. Clone the Repository

    git clone https://github.com/rSaiHarsha/Movie-lib-web.git
    cd movielibapplication

2. Set Up the Database
    1. Create a database in MySQL. 
    2. Import the provided SQL file to set up the necessary tables:

3. sql code 
    SOURCE path/to/your/database_file.sql;
    Update db_config.php in the db directory with your database credentials.

4. Configure OMDB API
    a. Obtain an API key from OMDB API.
    b. Replace the placeholder API key in the relevant files with your actual API key.

  ## Usage
        Sign Up: Register a new account.
        Log In: Log in with your credentials.
        Search Movies: Use the search bar on the home page to find movies.
        Create Lists: Add movies to lists, create new lists, and manage existing lists.
        Public and Private Lists: Toggle between making lists public or private.
## Steps to Run
1. Clone the repository: git clone https://github.com/rSaiHarsha/Movie-lib-web.git
2. Set up the database: Import the SQL schema and configure db_config.php.
3. Install dependencies: Ensure you have all the necessary PHP extensions installed.
4. Configure OMDB API: Replace the placeholder API key with your actual key.
5. Run the application: Start your web server and open the application in your browser.

