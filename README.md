## Installation

Clone repo

`git clone https://github.com/prolaxu/appcore.git`

### Connect Database

Currently Appcore only supports mysql.

Update your database info.

`->env.json`

```
{
    "site_url": "http://127.0.0.1/",
    "cache":false,
    "debug":false,
    "site_name": "Appcore",
    "favicon": "/favion.png",
    "description": "Small PHP VMC project set up",
    "database": {
        "host": "localhost",
        "user": "root",
        "pass": "",
        "name": "appcore"
    }
}
```

### Routings

Routing is handeled by Appcore you can specify your routes in

`->routes/web_router.php`

```
//init Route class
$router = new Route();

// routing / path to HomeController in index function
$router->get('/', 'HomeController@index');

```

### Controllers

We can create Controllers in folder.

`->app/controllers`

For Example : `HomeController`

```
<?php

namespace app\controllers; //namespace

//HomeController
class HomeController extends Controller
{
    //index function
    public function index()
    {
        $this->view('home');
    }
}

```

### Views

We use twig Templating engine to Seperate Front ends codes and backend code.
read more about twig.
https://twig.symfony.com/doc/3.x/templates.html

#### Some Demo

In HomeController

```
 public function index()
    {
        //Passing parameters to view
        $this->view('home', [
            'appname' => 'App core'
        ]);
    }
```

`->views/home.php`

```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App core</title>
</head>

<body>
    <div class="container">
        <h1>Welcome to {appname}.</h1>
        <p>Appcore is simple php project set to work in mvc partten. </p>
    </div>
</body>

</html>
```

### Database Utils

We can use DB class for common db queries.

For Example :

```
//use DB class  on top
use core\Tools\DB;

//init db class
$db=new DB();

//get data with no limit
$posts=$db->table('posts')->get();

//get data with limit 10
$posts=$db->table('posts')->get(10);

// get frist record
$post=$db->table('posts')->first();

//get order decending by id
$posts=$db->table('posts')->getDesc('id);

// get order ascending by id
$posts=$db->table('posts')->getDesc('id);

//Find row by id or any key
$post=$table('posts)->find(1)
or with key
$post=$table('posts)->find(1,'id')

//Insert  and it will return record
$post=$db->table('posts)->insert([
    'title'=>'Post Title',
    'body'=>"contents .....",
    ....
]);

//Update recored with id and it will return record
$post=$db->table('posts)->update(1,[
    'title'=>'Post Title',
    'body'=>"contents .....",
    ....
]);

//Delete recored with id  and it will return record
$table('posts)->delete(1)
```

## Authors

- [@prolaxu](https://www.github.com/prolaxu)
