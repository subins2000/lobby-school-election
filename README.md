# sElec

A Lobby app for conducting school elections. This was made for **Bethany St John's Kunnamkulam** and **GMGHSS Kunnamkulam** schools.

It is a really simple app and is very much configurable.

[Manual, Documentation, Help](http://subinsb.com/school-election)

## Configuration

### type

This app can be used for two types of elections :

* Normal Election - Vote candidates from a list
* Class Wise - Vote candidates in each class
* Boys & Girls - Vote candidates from **two lists** of boys and girls

#### Normal Election `single`

This is the **default** election type. There is **only one list** for all candidates (irrespective of gender) and the voter can choose from this list.

#### Class Wise `class`

Each classes vote separate for the candidates in their class. So, candidates can be added for each class and voting can be done.

#### Boys & Girls `multiple`

In this election type, there are two lists of candidates - one for girls and other for boys. The voter should choose from both the lists and not just one.

To enable this set `type` to `multiple`.

PS : This was the election type in Bethany to get representatives from both genders.

### able-to-choose

How many candidates can the voter (student) choose from the list ?

Example : If 2 persons can be chosen, then the value should be 2

### classes

The classes that is going to vote

### divisions

The divisions of classes

### max-strength

The maximum number of children in classes i.e. the number of students in the class that has the most number of students.

Example: If 5A has `60` students and 5B has `63` students, then the value should be `63`

### password

Whether voter should enter password to vote. `1` for TRUE and `0` for FALSE.

### default-class

When a voter visits the election page, which class should be seen selected ?

### default-division

When a voter visits the election page, which division should be seen selected ?

### disable-class-div-change

By default the student can choose the class and division. You can prevent theme from doing so by enabling this option.

`1` to prevent students from choosing the class and division.

`0` to allow students from choosing the class and division.

## Bethany

Don't mind this if you are not from Bethany

1) Make Squid pass username with URL requests

2) Make Database with table in tables.sql file

3) Run install.sh to change permissions
