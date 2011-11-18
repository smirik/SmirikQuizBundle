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
* Bundle is translated, see Resources/translations.

Requirements
------------

* Symfony2 with twig.
* Doctrine2, DoctrinExtension & DoctrinFixtures.
* [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) (please see the installation steps [here](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md)).
* Annotations for Controllers.
* [SonatajQueryBundle](https://github.com/sonata-project/SonatajQueryBundle) or SonataAdminBundle with all dependences.
* Twitter Bootstrap css file (or with the same styles).

Installation
------------

**THIS IS TEMPORARY STEPS**

* Copy files to src/Smirik/QuizBundle
* Add the following code to config.yml:

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

* Add routes to routing.yml:

 ```
  SmirikQuizBundle:
      resource: "@SmirikQuizBundle/Controller/"
      type:     annotation
      prefix:   /
  ```
* Update database and load fixtures

  ```
  php app/console doctrine:schema:update --force
  php app/console doctrine:fixtures:load --append
  ```
    
* Enjoy!

Database schema
---------------

![Database schema](http://4xxi.com/images/SmirikQuizBundle-DB.png)

How to use
----------

* Bundle has its own layout Resources/views/layout.html.twig extending base.html.twig. All templates extending this layout.
* There are 4 controllers:
  * AdminQuestionController (/admin/questions/*) for questions management,
  * AdminQuizController (/admin/quiz/*) for quizes management,
  * AdminUserController (/admin/quiz-users/*) for assigning users to quizes,
  * QuizController (/quiz/*) — frontend for users.
* Access to all parts is granted just for authorized users.
* Just ROLE_ADMIN users have access to /admin/* parts.
* To start test quiz you should login (/login) and go to /quiz webpage.

License
-------

MIT.
