Revision History
=========================

v0.1 (2017-04-04)
-------------------------

First working version of the micro framework.

Includes cimage


v1.0.0 (2017-04-10)
-------------------------

Build me-page with home, about and report-pages. Built a navbar.


v2.0.0 (2017-04-19)
-------------------------

Added classes for Navbar and Session and routes for session

v2.0.1 (2017-04-23)
-------------------------

Added a calendar, with classes, navigation, and view

v3.0.0 (2017-05-08)
-------------------------

Added login funcionality, admin pages and admin privileges

v4.0.0 (2017-05-24)
-------------------------

Förbättrade route för tillgång till admin-sidor, med en route admin/** vilket gör att alla routes under admin/ kontrolleras.

v4.0.1 (2017-05-24)
-------------------------

Skapade metoden renderPage() i app-klassen. För att korta ner koden i routerna. Jag sänder $title och $page (och $data om det behövs) till app->renderPage, och sparar kodrader.

v4.0.2 (2017-05-24)
-------------------------

I composer.json lade jag till autoload: files: ['src: functions.php'] vilket gör det lätt att använda hjälpfunktioner, vilka jag kan samla i den filen.

v4.0.3 (2017-05-25)
-------------------------

Jag införlivade med composer anax/textfilter, så att jag kan använda mig av textfiltrena nl2br, bbcode, clickable och markdown. Lade också till en route 'textfilter', där filtrena testas.

v4.0.4 (2017-05-27)
-------------------------

Added CRUD for content, blog and block pages.

v5.0.0 (2017-06-04)
-------------------------

Added CRUD for webbshop backend.

v5.0.1 (2017-06-06)
-------------------------

Created SQL procedures for handling webshop: Shopping cart and order. Improved security by escaping input/output.


v5.0.2 (2017-06-06)
-------------------------

Updated docblocks in calsses and generated documentation with phpdoc.
