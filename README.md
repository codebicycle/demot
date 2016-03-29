# DeMoT (Detention Monitoring Tool)

>
Sa se dezvolte o aplicatie Web pentru gestiunea vizitelor de care beneficiaza persoanele condamnate la executarea unei pedepse intr-un penitenciar sau intr-o casa de corectie. Fiecarei vizite i se vor atasa informatii privind individul ori indivizii care efectueaza vizita -- minimal, se vor considera: identitatea, fotografia, relatia cu condamnatul (ruda, tutore legal, avocat, prieten), natura vizitei. De asemenea, vor fi consemnate: data realizarii intrevederii, natura si durata acesteia (e.g., consultare privind recursul procesului, vizita amicala), posibile obiecte/date furnizate condamnatului sau oferite de condamnat vizitatorului/vizitatorilor, rezumatul discutiilor efectuate (daca nu e incalcata confidentialitatea), starea de sanatate si de spirit a detinutului, martorul/martorii la intalnire etc. Instrumentul implementat va genera statistici -- documente HTML, CSV si JSON -- vizand vizitele realizate per individ, perioada de timp, in functie de categoria pedepsei savarsite sau alte criterii. Pentru interactiunea cu utilizator, se va oferi un design Web responsiv.


<b>Schedule inmate visits (the easy way). Easy for the visitor, easy for the institution.</b>
          
DeMoT follows the Model View Controller pattern, has clean RESTful urls and a simple structure inspired by [PHP Mini][mini].  
Written in PHP 7 with only native code, no frameworks or libraries.


## Installation
1. Clone this repository
    ```
      git clone https://github.com/codebicycle/demot.git
    ```

2. Create a new user and grant permissions in mysql

    Login to mysql as the root user
    ```
      mysql -u root -p
    ```
    at the mysql prompt
    ```
      CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
      GRANT ALL PRIVILEGES ON database_name . * TO 'newuser'@'localhost';
    ```
3. Edit the database credentials in `application/config/config.php`
4. Execute the `.sql` statements in the `_install/` folder (with PHPMyAdmin for example).
5. Make sure you have `mod_rewrite` activated on your server / in your environment. Some guidelines:
   [Ubuntu 14.04 LTS](http://www.dev-metal.com/enable-mod_rewrite-ubuntu-14-04-lts/),
   [Ubuntu 12.04 LTS](http://www.dev-metal.com/enable-mod_rewrite-ubuntu-12-04-lts/),
   [EasyPHP on Windows](http://stackoverflow.com/questions/8158770/easyphp-and-htaccess),
   [AMPPS on Windows/Mac OS](http://www.softaculous.com/board/index.php?tid=3634&title=AMPPS_rewrite_enable/disable_option%3F_please%3F),
   [XAMPP for Windows](http://www.leonardaustin.com/blog/technical/enable-mod_rewrite-in-xampp/),
   [MAMP on Mac OS](http://stackoverflow.com/questions/7670561/how-to-get-htaccess-to-work-on-mamp)


## Resources

[PHP Mini][mini], simple MVC skeleton PHP aplication  
PHP [PSR-1][psr1] coding standard  

[mini]:      https://github.com/panique/mini
[psr1]:      http://www.php-fig.org/psr/psr-1/


### Git Cheatsheet

Create a local branch tracking a remote branch from the repository
```
git checkout -b branch_name origin/branch_name
```

#### Git Workflow

>
Once a pull request is accepted, you need to make sure your local dev branch is synchronized with the repository dev branch. Then, you merge the feature branch into dev and push the updated dev back to the central repository.

https://www.atlassian.com/git/tutorials/comparing-workflows/feature-branch-workflow

http://nvie.com/posts/a-successful-git-branching-model/
