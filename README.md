# Social Web Group 17

This repository is a project of Group 17 for course The Social Web in 2020 at Vrije Universiteit Amsterdam. Our project is about Twitter user opinions regarding current coronavirus outbreak. 

## Data Collection

Our dataset is collected using Twitter Standard API. The main parameters include:

- q='#coronavirus  -filter:retweets'  #Search Tweets containing coronavirus hashtag and ignores retweets
- geocode   #set geolocation code based on user locations
- tweet_mode='extended'   #set extended mode to retrieve full text of tweets
- endpoint=search.tweets   #using standard search API

Because the standard search API only return 100 results at one time, we send the id of the last tweets of last result to as max_id parameter to the new request. By looping it we are able to collect full data. Besides, the API has a 7-day limit, we need to run the script serveral times in different weeks.

The script can be found at ``collect.py``. It collects data with Twitter API, formats it and stores it in a MySQL database. The dataset can be found at ``dataset/socialweb.sql`` and it contains data from February 11th, 2020 to March, 6th 2020.


## Data Pre-processing

Before using the data for analysis, we firstly removed duplicated contents in database. Then we removed the links in each Tweet as they are not useful for further analysis in our project.


## Data Analysis

We performed sentiment analysis with Textblob and emotion analysis with Textblob and NRC EmoLex. The script can be found at ``analyze.py``. It reads Tweets from database, performs analysis, and stores the result in ``results`` table of the MySQL database.

Besides that, we also did cloud word, frequently and so on. These can be found at jupyter files ending with ``.ipynb``


## Interactive Visualization

We built a website for interactive visualization. The source files of the website can be found at ``web/``. The backend was written in PHP which handles users' requests, reads data from database, and feeds front-end with JSON data.

The front-end is built with bootstrap and jQuery. Also, chart.js was used for rendering grahps.

The running environment for the website is listed below.

- Debian 10 x64
- nginx/1.14.2
- PHP-fpm 7.3.14

### Live Demo

A live demo can be found at http://social.jybb.me 


## Other Files
- config.ini  # Configuration about MySQL connection and Twitter API information
