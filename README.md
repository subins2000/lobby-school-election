# School Election

A Lobby app for conducting school elections. This was made for **Bethany St John's Kunnamkulam** and **GMGHSS Kunnamkulam** schools.

It is a really simple app and is very much configurable.

## Configuration

### type

This app can be used for two types of elections :

* Normal Election - Vote persons from a list
* Boys & Girls - Vote persons from **two lists** of boys and girls

#### Normal Election `single`

This is the **default** election type. There is **only one list** for all candidates (irrespective of gender) and the voter can choose from this list.

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

### male-candidates

Number of Male Candidates in the election

### female-candidates

Number of female candidates in the election

### total-candidates

Total candidates in the election

## Bethany

Don't mind this if you are not from Bethany

1) Make Squid pass username with URL requests
2) Make Database with table in tables.sql file
3) Run install.sh to change permissions
