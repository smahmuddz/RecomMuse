# Music Recommendation System

Welcome to the Music Recommendation System project! This project is designed to provide users with recommendations for music albums and songs based on their preferences. Users can register, log in, and interact with a collection of albums and songs.

## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Database Structure](#database-structure)
- [Contributing](#contributing)
- [License](#license)

## Snapshots

<img src="https://github.com/smahmuddz/RecomMuse/assets/85384973/4daf050a-bb01-4fea-989f-cc32e861d7e0" alt="Image 1" width="80%">
<div style="display: flex; justify-content: space-between;">
  <img src="https://github.com/smahmuddz/RecomMuse/assets/85384973/c91939a1-6fb6-4d22-8105-038f274db613" alt="Image 2" width="40%">
  <img src="https://github.com/smahmuddz/RecomMuse/assets/85384973/1f8b7ef8-b18a-4419-9adc-6f939d514d10" alt="Image 3" width="40%">
</div>

## Features

- User Registration: Users can create accounts with their name, email, password, and UID.
- User Authentication: Registered users can log in securely.
- Music Library: Explore a collection of music albums and songs.
- Liked Songs: Users can like and unlike songs, and their preferences are stored.
- Recommendation Engine: Provides music recommendations based on user interactions.

## Getting Started

Follow these instructions to set up and run the Music Recommendation System on your local machine.

1. Clone the repository:

   ```shell
   git clone https://github.com/yourusername/music-recommendation-system.git
   ```

2. Install the required dependencies:

   ```shell
   # Navigate to the project directory
   cd music-recommendation-system

   # Install dependencies (e.g., PHP, MySQL, Apache)
   # Set up your web server to serve the project
   ```

3. Set up the database:
   - Import the `database.sql` file into your MySQL database. This file contains the schema and initial data.

4. Configure the database connection:
   - Open the `database.php` file and update the database connection settings (e.g., hostname, username, password).

5. Start your web server (e.g., Apache) and navigate to the project in your web browser.

6. You can now register an account, log in, and explore the music library.

## Usage

- Register an account with a valid email, name, and UID.
- Log in with your registered email and password.
- Explore the music library to discover albums and songs.
- Like and unlike songs to improve music recommendations.

## Database Structure

The database for this project is structured as follows:

- `albums`: Stores information about music albums.
- `artists`: Contains data about music artists.
- `liked_songs`: Records user likes and dislikes for songs.
- `songs`: Stores details about individual songs.
- `users`: Manages user accounts and profiles.

Refer to the `database.sql` file for the complete database schema and initial data.

## Algorithm
The algorithm is referred to as the "Song Similarity and Ranking Algorithm." This algorithm is a crucial component of the Music Recommendation System (RecomMuse) described in the paper. Its primary purpose is to calculate the similarity between pairs of songs based on various factors and then rank these songs by their combined similarity scores. Below, I'll explain this algorithm in more detail:

1. **Input Data**: The algorithm requires access to specific database tables, including "users," "songs," and "liked\_songs." These tables store information about users, songs, and user interactions, such as liking and unliking songs.

2. **Initialization**: The algorithm begins by initializing an empty list to store song objects along with their respective combined similarity scores.

3. **Iterating Over Song Pairs**: For each unique pair of songs (s1, s2) retrieved from the "songs" table, the algorithm performs the following steps:

   a. **Genre Similarity Calculation**: It calculates the similarity component for song genres (genre\_similarity). This involves counting the number of common genres between s1 and s2 and then dividing it by the total number of unique genres between these songs.

   b. **Language Similarity Calculation**: Similar to genre similarity, it calculates the language similarity component (language\_similarity) based on the commonality of song languages.

   c. **User Liking Similarity Calculation**: This step considers user interactions. It retrieves the list of users who liked and unliked s1 and s2 from the "liked\_songs" table. It calculates the number of common users who liked s1 and unliked s2, as well as the number of common users who liked s2 and unliked s1. These are used to compute the liking similarity component (liking\_similarity).

   d. **User Unliking Similarity Calculation**: Similar to liking similarity, this step calculates the unliking similarity component (unlike\_similarity) based on common users who unliked s1 and s2.

   e. **Combined Similarity Score**: The algorithm combines these similarity components using specified weights (e.g., 0.4 for genre, 0.2 for language, 0.4 for liking, and 0.2 for unliking). The combined similarity score (combined\_similarity) for the song pair (s1, s2) is computed as a weighted sum of these components.

   f. **Update Song Objects**: For each song s1, a song object is created (if not already created), and its combined similarity score is updated by adding the computed combined\_similarity value.

4. **Ranking Songs**: Once all song pairs have been processed, the algorithm sorts the list of song objects by their combined similarity scores in descending order. This results in a ranked list of songs, where songs with higher combined similarity scores appear at the top.

5. **Output**: The algorithm returns the ranked list of songs as its output.
In summary, this algorithm plays a crucial role in the RecomMuse Music Recommendation System by calculating the similarity between songs based on genre, language, user liking, and user unliking behaviors. It then ranks these songs by their combined similarity scores, allowing the system to provide personalized and relevant music recommendations to users. The use of collaborative filtering and content-based features contributes to a more comprehensive and adaptable recommendation system.

## Contributing

Contributions are welcome! Feel free to open issues or pull requests to improve this project.
