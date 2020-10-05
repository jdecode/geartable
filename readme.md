## GearTable
Web app to create APIs from Google Spreadsheets, using CakePHP and MySQL (v1) and to be moved to DynamoDB(in v2)



### Installation steps
1. You need docker - if you don't have it, please Google or use this link [Install Docker on Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04)
1. Clone the repo: `git clone git@github.com:jdecode/geartable.git`
1. `cd geartable`
1. `docker-compose run geartable composer install -n --prefer-dist`
1. `docker-compose build --no-cache` (or you can ignore the no-cache attribute if you are sure that there is no cache issue)
1. `docker-compose up`
1. The app should be now running at 131.31.1.1 locally, if not, then please create an issue on this repo

