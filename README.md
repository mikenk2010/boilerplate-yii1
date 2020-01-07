Yii Web Programming Framework
=============================

## Installation

- Install `composer` and run update `composer`

## Guide

- Main working folder `mih`
- Theme at this path `mih/themes/makeithappen` keeps developing on this theme
- Database is using SQLite `mih/protected/data/mih.db`, no need to connect to MySQL or any others

- Developer Document [link](https://www.yiiframework.com/doc/guide/1.1/en)

## Requirements
- [ ] Enable XDebug
- [ ] Enable send email SMTP
- [ ] Deploy to Heroku

## Optional
- [ ] Enable Travis for Auto Deployment

## Screenshots

![Home Page](https://i.imgur.com/49XqDy0.png)

![XDebug](https://i.imgur.com/yszUnvp.png)

## Google Login

- Guide [link](https://developers.google.com/identity/sign-in/web/sign-in)

## Deploy Yii to Heroku
1. Install Heroku CLI (link)[https://devcenter.heroku.com/articles/getting-started-with-php#set-up]
2. Create Heroku Account
3. Create Heroku App
- Run `heroku create` inside your repository

![Heroku Create](https://i.imgur.com/2JD2R6e.png)

4. Deploying with Git
- Run `heroku git:remote -a <your app on step 3>

![Deploy with Git](https://i.imgur.com/adLLRZJ.png)

