A website could implement this solution by making a button at every news atricle and sending get request with the corresponding news articleId to: localhost/8000/comments/{articleId}

I don't think the code needs much explaining, I believe it's all common Symfony practice. I could've maybe made it a bit better by using ajax to live reload the adding of comments.


To run the project:

Connect to a database by adjusting the values in /config/parameters.yml (leave the database name as 'Comments')

Setting up the databse by moving into the project folder and excecute the follwing commands: (or create the database manually)

php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force

Now everything is setup and you can run the project in phpstorm and naviage to localhost/8000/comments/{articleId}


If this doens't work somehow you might need to generate the enity again:


php bin/console doctrine:generate:entity

'The entity shortcut name': 'AppBundle:Comment'
'field name 1': 'message' -> settings all default
'field name 2': 'username' -> settings all default
'field name 3': 'articleId' -> nullable: true (so it doesn't require a form input)

