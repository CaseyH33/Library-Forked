# _Library_

#### _Library app built to work with "many to many" mySQL database, 8/18/2015_

#### By _**Charles Moss, Austin Blanchard, Casey Heitz & Mike Chastain**_

## Description



* As a librarian:
The user can search for book via "author's name" or "book's title".
* As a patron:
The user can check for available copies of a book and check out the copy of the book from the library. Patrons can view due date and history of checkouts.




## Setup
When installing from source you may notice that once you have cloned this repo, that this project makes use of a PHP Dependency Manager: [Composer](https://github.com/composer/composer). Once you have Composer installed you can acquire any project dependencies via your shell by entering:

```
$ composer install
```

[setting up mySQL database for this project](https://github.com/CharlesAMoss/epic_ToDo_mySQL/blob/master/SQL_todo_setup.md)

_You then only need to start up a local PHP server from within the "web" directory within the project's folder and point your browser to whatever local host server you have created._

## Database Setup

Exported DB file can found in DB folder.

To produce the "library_test" database, make a copy via myPHPadmin by selecting "library" and clicking the "Operations" tab. You will see a "copy database to:" section, fill the input with "library_test", select "Structure only", and click "Go".


## Technologies Used
_This project makes use of PHP, mySQL, the testing framework [PHPUnit](https://phpunit.de/), the micro-framework [Silex](http://silex.sensiolabs.org/), and uses [Twig](http://twig.sensiolabs.org/) templates._

## To Do

* build silex
* build twig
* profit

### Legal

Copyright (c) 2015 Charles A Moss, Mike Chastain, Casey Heitz & Austin Blanchard

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
