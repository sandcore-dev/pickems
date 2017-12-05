# Pickems

This Laravel application is a newer version of a previously written application
that didn't make use of any frameworks.

I use this application to manage a private *pickems* competition. You probably
have heard of the term through (American) football pools. However, this pickems
application is mainly for motorsports, Formula One in particular.

It can be used for any sports consisting of one or more competitors belonging to
a team, and who are ranked after each event.

Since this application is used for private purposes, there is no registration
form available and users can't manage any leagues. Users with admin authorization
have superuser privileges, which means they can access everything.

The application uses very little JavaScript (needed only for the pages that use
[Highcharts](https://www.highcharts.com/)) and should work on most devices thanks
to Bootstrap's responsive classes.

Regular user components are:

* Profile
* Picks
* Standings
* Several statistical pages

Superuser components include:

* Series
* Seasons
* Races
* Circuits
* Entries
* Drivers
* Teams
* Countries
* Results
* Picks
* Users
* Leagues
* User's leagues

> **Note:** "User's leagues" could be written as "Users' leagues" but since you
> have to select a user before you can associate or dissociate with leagues,
> I decided to leave it as is.

## Todo

* Probably add a page to explain the rules and points system
* Implement multiple languages
* Add timezone to profile

