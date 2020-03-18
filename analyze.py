import twitter
import json
import mysql.connector
import datetime
from textblob import TextBlob
from textblob_nl import PatternTagger, PatternAnalyzer
import configparser
import re


config = configparser.ConfigParser()
config.read('config.ini')

mydb = mysql.connector.connect(
    host=config['mysql']['host'],
    user=config['mysql']['user'],
    passwd=config['mysql']['passwd'],
    database=config['mysql']['database']
)

mycursor = mydb.cursor()

#Sentiment analysis by textblob
def sentiment():
    mycursor.execute("SELECT id, text, iso_language_code FROM tweets WHERE iso_language_code = 'en' AND id NOT IN (SELECT id FROM results)")
    row = mycursor.fetchall()
    val = []
    for single in row:
        id = single[0]
        singleBlob = TextBlob(single[1])  # English
        # singleBlob = TextBlob(single[1], pos_tagger=PatternTagger(), analyzer=PatternAnalyzer())  # Dutch
        sen = 'neutral'
        polarity = singleBlob.sentiment[0]
        if polarity == 0:
            sen = 'neutral'
        elif polarity > 0:
            sen = 'positive'
        elif polarity < 0:
            sen = 'negative'

        # tup = (id, sen, polarity)
        # tup = (sen, round(polarity,2), id)

        tup =  (id, sen, round(polarity, 2))
        val.append(tup)

    # sql = "UPDATE results SET sentiment = %s, sentiment_polarity = %s WHERE id = %s"
    sql = "INSERT INTO results (id, sentiment, sentiment_polarity) VALUES (%s, %s, %s)"
    mycursor.executemany(sql, val)
    mydb.commit()


#emotion analysis with nrc emotion lexicon
def emotion ():
    emotionList = []

    with open('dataset/NRC-Emotion-Lexicon-Wordlevel-v0.92.txt', 'r') as nrcFile:
        lines = nrcFile.readlines()
        for line in lines:
            emotionList.append(line.split())
    # print (emotionList)

    mycursor.execute("SELECT id, text, iso_language_code FROM tweets NATURAL JOIN results WHERE iso_language_code = 'en'")
    row = mycursor.fetchall()
    sql = 'UPDATE results SET emotion = %s WHERE id = %s'

    val = []
    for single in row:
        id = single[0]
        text = single[1].lower()

        singleBlob = TextBlob(text)

        thisEmotion = []
        # print(words)

        negativeWords = ['not', 'n\'t','none', 'no']

        for sentence in singleBlob.sentences:
            words = sentence.words
            # wordList = sentence.ngrams(3)
            i = 0
            for word in words:
                i += 1
                for emotionWord in emotionList:
                    if word in emotionWord:
                        if emotionWord[2] == '1' and emotionWord[1] not in ['positive', 'negative']:
                            if i == 2:
                                if words[i - 1] in negativeWords:
                                    continue
                            if i > 3:
                                if words[i - 1] in negativeWords or words[i - 2] in negativeWords:
                                    continue
                            thisEmotion.append(emotionWord[1])
        thisEmotion = list(dict.fromkeys(thisEmotion))
        list.sort(thisEmotion)

        thisEmotionStr = ','.join(elem for elem in thisEmotion)
        print (str(id) + " " + thisEmotionStr)
        if (thisEmotionStr != ''):
            tup = (thisEmotionStr,id)
            mycursor.execute(sql,tup)
            mydb.commit()

sentiment()
emotion()
