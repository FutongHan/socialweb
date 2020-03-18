import twitter
import json
import mysql.connector
import datetime
from difflib import SequenceMatcher
import time
import configparser

def similar(a, b):
    return SequenceMatcher(None, a, b).ratio()

config = configparser.ConfigParser()
config.read('config.ini')

mydb = mysql.connector.connect(
    host=config['mysql']['host'],
    user=config['mysql']['user'],
    passwd=config['mysql']['passwd'],
    database=config['mysql']['database']
)

mycursor = mydb.cursor()

CONSUMER_KEY = config['twitter']['CONSUMER_KEY']
CONSUMER_SECRET = config['twitter']['CONSUMER_SECRET']
OAUTH_TOKEN = config['twitter']['OAUTH_TOKEN']
OAUTH_TOKEN_SECRET = config['twitter']['OAUTH_TOKEN_SECRET']

auth = twitter.oauth.OAuth(OAUTH_TOKEN, OAUTH_TOKEN_SECRET, CONSUMER_KEY, CONSUMER_SECRET)
twitter_api = twitter.Twitter(auth=auth)

q = '#Coronavirus -filter:retweets'  # XXX: Set this variable to a trending topic, or anything else you like.
count = 100  # number of results to retrieve

geocode = '22.2793278,114.1628131,50km'  # Hong Kong
locationame = 'Hong Kong'
# geocode = '1.340863,103.8303918,50km' #Singapore
# locationame = 'Singapore'
# geocode = '52.5001698,5.7480821,120km' #Netherlands
# locationame = 'Netherlands'
# geocode = '39.7837304,-100.4458825,100mi'  # usa
# locationame = 'USA'

max_id = '1336622344745168897'

for day in range(29, 28, -1):
    # until = '2020-02-' + str(day)
    until = '2020-03-01'
    for x in range(8):
        search_results = twitter_api.search.tweets(q=q, count=count, lang='en', geocode=geocode, tweet_mode='extended',
                                                   until=until, max_id=max_id)
        # print(json.dumps(search_results, indent=1))
        statuses = search_results['statuses']
        # print(json.dumps(statuses, indent=1))

        sql = "INSERT INTO tweets (tweet_id,text,created_at,iso_language_code,result_type,favorite_count, retweet_count, location, " \
              "user_id, user_location, user_name,user_screen_name,user_friends_count,user_followers_count,user_statuses_count,user_created_at) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"

        valList = []
        f = '%a %b %d %H:%M:%S %z %Y'
        for status in statuses:
            thisUser = status['user']

            RT = 0
            if 'retweeted_status' in status:
                RT = similar(status['full_text'], status['retweeted_status']['full_text'])

            # only log tweets that are not similar with the original tweets
            if RT < 0.7:
                thisStatusTuple = (
                    status['id_str'], status['full_text'], datetime.datetime.strptime(status['created_at'], f),
                    status['metadata']['iso_language_code'], status['metadata']['result_type'],
                    status['favorite_count'], status['retweet_count'], locationame,
                    thisUser['id_str'], thisUser['location'], thisUser['name'], thisUser['screen_name'],
                    thisUser['friends_count'], thisUser['followers_count'], thisUser['statuses_count'],
                    datetime.datetime.strptime(thisUser['created_at'], f))
                valList.append(thisStatusTuple)

        # print (valList)

        mycursor.executemany(sql, valList)
        mydb.commit()
        time.sleep (5)

        print("last: " + statuses[-1]["id_str"])
        print("0: " + statuses[0]["id_str"])
        max_id = statuses[-1]["id_str"]
