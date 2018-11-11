Yii2 Post Management System
====================
Post Management System for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist thienhungho/yii2-post-management "*"
```

or add

```
"thienhungho/yii2-post-management": "*"
```

to the require section of your `composer.json` file.

### Migration

Run the following command in Terminal for database migration:

```
yii migrate/up --migrationPath=@vendor/thienhungho/PostManagement/migrations
```

Or use the [namespaced migration](http://www.yiiframework.com/doc-2.0/guide-db-migrations.html#namespaced-migrations) (requires at least Yii 2.0.10):

```php
// Add namespace to console config:
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationNamespaces' => [
            'thienhungho\PostManagement\migrations\namespaced',
        ],
    ],
],
```

Then run:
```
yii migrate/up
```

Config
------------

Add module PostManage to your `AppConfig` file.

```php
...
'modules'          => [
    ...
    /**
     * Post Manage
     */
    'post-manage' => [
        'class' => 'thienhungho\PostManagement\modules\PostManage\PostManage',
    ],
    ...
],
...
```

Modules
------------

[PostBase](https://github.com/thienhungho/yii2-post-management/tree/master/src/modules/PostBase), [PostManage](https://github.com/thienhungho/yii2-post-management/tree/master/src/modules/PostManage)

Functions
------------

[Core](https://github.com/thienhungho/yii2-post-management/tree/master/src/functions/core.php)

Constant
------------

[Core](https://github.com/thienhungho/yii2-post-management/tree/master/src/const/core.php)

Models
------------

[Post](https://github.com/thienhungho/yii2-post-management/tree/master/src/models/Post.php), [PostType](https://github.com/thienhungho/yii2-post-management/tree/master/src/models/PostType.php), [TermOfPostType](https://github.com/thienhungho/yii2-post-management/tree/master/src/models/TermOfPostType.php)