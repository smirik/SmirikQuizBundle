QuizBundle
==========

Introduction
------------

This bundle provides quiz functionality as standalone symfony2 bundle. Created by [4xxi.com](http://4xxi.com/en). [All bundles](http://4xxi.com/en/symfony) by 4xxi.

Features
------------

* Unlimited quiz creation.
* Every quiz can have different number of questions. The question's database could have much more questions than need. For quizes questions are taken randomly.
* Every question can have any number of answers (radio-button answers) or text answer (input field).
* Question & answer can have image.
* Quiz could be limited by time (e.g. 10 minutes).
* It is possible to hide quiz from users. The administrator can manually assign users to quiz.
* Bundle is translated, see Resources/translations. Some translations on english could be missed because of rapidly development.

Requirements
------------

* Symfony2 with twig.
* Doctrine2, DoctrineExtension & DoctrineFixtures.
* [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) (please see the installation steps [here](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md)).
* Annotations for Controllers.
* jQuery & twitter bootstrap css / js or similar.
* It is recommended to use this bundle with [SmirikAdminBundle](https://github.com/smirik/SmirikAdminBundle) which provides public assets (including twitter bootstrap & jquery) + menu + core classes.

Installation
------------

* Add bundle to your `deps` file:

  ```
  [SmirikQuizBundle]
    git=git://github.com/smirik/SmirikQuizBundle.git
    target=/bundles/Smirik/QuizBundle
  ```

* Register the namespace in `autoload.php` (if you don't use other Smirik* bundles):

  ```
  $loader->registerNamespaces(array(
      ...
      'Smirik'           => __DIR__.'/../vendor/bundles',
  ));
  ```

* Register bundle in your `AppKernel.php`:

  ```
  $bundles = array(
      ...
      new Smirik\QuizBundle\SmirikQuizBundle(),
      ...
  );
  ```

* Add the following code to `config.yml`:

  ```
  fos_user:
        db_driver: orm # other valid values are 'mongodb', 'couchdb'
        firewall_name: main
        user_class: Smirik\QuizBundle\Entity\User
        group:
            group_class: Smirik\QuizBundle\Entity\Group

  ...
  twig:
      debug:            %kernel.debug%
      strict_variables: %kernel.debug%
      form:
        resources:
          - 'SmirikQuizBundle:Form:fields.html.twig'
  ```

* Add routes to `routing.yml`:

 ```
  SmirikQuizBundle:
      resource: "@SmirikQuizBundle/Controller/"
      type:     annotation
      prefix:   /
  ```
* Update database and load test fixtures to see admin functionality

  ```
  php app/console doctrine:schema:update --force
  php app/console doctrine:fixtures:load --append
  ```

* See test quiz at `http://host/admin/quiz/`

* Please check that `bootstrap.css` file is loaded. 
    
* Enjoy!

Database schema
---------------

![Database schema](http://4xxi.com/images/SmirikQuizBundle-DB.png)

How to use
----------

* Bundle has its own layout `Resources/views/layout.html.twig` extending `base.html.twig`. All templates extending this layout. All admin templates extends `Resources/views/Admin/layout.html.twig`.
* There are 4 controllers:
  * AdminQuestionController (/admin/questions/*) for questions management,
  * AdminQuizController (/admin/quiz/*) for quizes management,
  * AdminUserController (/admin/quiz-users/*) for assigning users to quizes,
  * QuizController (/quiz/*) — frontend for users.
* Access to all parts is granted just for authorized users.
* Just ROLE_ADMIN users have access to /admin/* parts.
* To start test quiz you should login (/login) and go to /quiz webpage.

Roadmap
-------

* Comments, pulls, reviews, forks are welcome!

License
-------

MIT.
