# Gymnasiearbete
Detta arbete är gjort av **Anton Norman**, **Elvira Ling** och **Vilgot Kihlberg**
## Idén
> Tanken är att vi ska skapa ett *journalsystem för sjukvården*.

### Säkerhet
Stor vikt kommer läggas på systemets säkerhet, då det i praktiken är menat att hantera personuppgifter och tidigare journaluppgifter 
som kan klassas som känsliga uppgifter. Med detta i åtanke har vi tänkt att skapa ett inloggningssystem som grundar sig i 
**personliga säkerhetsnycklar** (tokens), som genereras med hjälp av kontots lösenord. Lösenordet kommer endast användas för att 
generera dessa nycklar, som i sin tur används vid inloggning. Vi har även tänkt att en sådan säkerhetsnyckel endast kommer kunna 
användas en gång och kommer sedan raderas ur systemet. Vid nästa inloggning kommer man alltså behöva generera en ny säkerhetsnyckel. 
*Tokensystemet* har vi tänkt skapa så det liknar det system GitHub nyligen infört.

## Tekniker
- PHP: 8.1
- SQLite: 3.0
- twig: 3.3
- pecee/simple-router 4.3.7.2

### Tekniker
Vår tanke initiellt var att använda php för att skapa detta system, men vi har istället valt att använda pythonramverket 
Django, med stöd för HTML och databas hantering. Anton, med huvudansvar för backend delen, är mycket mer bekväm med python 
än php och har även mer erfarenhet där. Django är även ett mycket väl utvecklat och dokumenterat ramverk så det råder ingen brist 
på information eller funktionalitet. 

## Uppdatering 10/1 -22
Med tanke på tidsbrist kommer vi istället för att skapa ett *tokensystem*, använda oss utav ett vanligt lösenordssystem, men där det verkliga
lösenordet inte sparas utan kommer gå genom en kryptering för att vara oigenkännligt. Vi vår plan är att använda den säkraste krypteringsteknik
vi kan hitta då det är mycket viktigt med hög säkerhet i ett system som detta.


## Uppdatering 10/1 -22 
Vi är åter tillbaka till att använda php tekniker för att utveckla detta system. Med terminens gång har vi lärt oss alltmer om detta och även 
fått tankar och idéer på hur vi skulle kunna skapa vårt system med dessa tekniker. Vi har därför efter en del research valt att återgå till våra
ursprungliga tankar på att använda php hädanefter. Vi väljer dock att ha kvar Django koden i projektet ur läro- och bedömningssyfte

## Uppdatering 14/1 -22
Efter att ha skissat färdigt all design till det grafiska gränssnittet och tagit alla designbeslut har vi börjat implementera
designen i vårt projekt. Vid nuläget är all HTML och CSS för inloggningssidan klar och vi arbetar med att fixa resten.

## Uppdatering 24/1 -22
Vi har tagit beslutet att använda twig med tanke på säkerhet.

## Uppdatering 4/3 -22
Vi har klarställt routningen för att både göra systemets URL mer lättläst, samt säkrad från SQL inmatning. Den fungerar nu som den ska 
och den är etablerad över hela systemet. 

## Färgkoder vi använder:
#EA4C6C - Röd,
#3567C1 - Blå


## **OBS!** Fr.o.m 10/1 -22 gäller nedanstående inte längre
### Starta Server
>Detta behövder du ha installerat på din maskin innan du kan starta servern:
* Python3 
    * pip (Package Installer Python), bör ingå i python istallationen
* Django (https://docs.djangoproject.com/en/1.8/howto/windows/)
    * **OBS!** Länken gäller endast installation på Windows
* Alla projektets filer

> För att starta servern där programmet kommer hållas, gör följande: 
* Öppna valfri kommandorad
* ta reda på din lokala IP adress
    * Om den inte redan finns där, lägg in den i ALLOWED_HOSTS i filen GA/src/backend/GA/GA/settings.py
* Navigera dig till %home%/GA/scr/backend/GA
* Kör ```python3 manage.py runserver YOUR_IP:8000``` i kommandoraden
    * Fungerar på Windows, Linux och MacOS
    