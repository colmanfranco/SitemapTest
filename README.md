# Sitemap Tool

This is a tool that generates and saves an XML file for the site www.musement.com for a given locale. 
This tool was developed using Laravel with no help of any external libraries.

Accepted locales:
- es-ES.
- fr-FR.
- it-IT.

Locale values should be passed through header as ```Accept-Language```.

You can get a list of cities, and for each city, you can fetch their list of activities using the { city_id } (for practial porposes I put a limit of 20 for each one). Will show how in a practical example.

### To start installing all dependencies do
```
composer install
```
### After that do
```
php artisan key:generate
```
### And serve
```
php artisan serve
```
## Root URL
```
localhost:8000
```
## Get Cities
```
GET {{ root_url }}/api/cities
```
### Base response
![Cities Base Response](img\citiesBaseResponse.png)

With the ```{ city_id }``` you can make a request to see the activities in the targeted city.

## Get Activities
```
GET {{ root_url }}/api/cities/{ city_id }/activities
```
### Base response
![Activities Base Response](img\activitiesBaseResponse.png)