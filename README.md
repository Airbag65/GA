# Gymnasie Arbete
Detta arbete är gjort av **Anton Norman**, **Elvira Ling** och **Vilgot Kihlberg**
## Idén
> Tanken är att vi ska skapa ett *journalsystem för sjukvården*.

### Säkerhet
Stor vikt kommer läggas på systemets säkerhet, då det i praktiken är menat att hantera personuppgifter och tidigare journaluppgifter som kan klassas som känsliga uppgifter. Med detta i åtanke har vi tänkt att skapa ett inloggningssystem som grundar sig i **personliga säkerhetsnycklar** (tokens), som genereras med hjälp av kontots lösenord. Lösenordet kommer endast användas för att generera dessa nycklar, som i sin tur används vid inloggning. Vi har även tänkt att en sådan säkerhetsnyckel endast kommer kunna användas en gång och kommer sedan raderas ur systemet. Vid nästa inloggning kommer man alltså behöva generera en ny säkerhetsnyckel. *Tokensystemet* har vi tänkt skapa så det liknar det system GitHub nyligen infört.

### Tekniker
Vår tanke initiellt var att använda php för att skapa detta system, men vi har istället valt att använda pythonramverket Django, med stöd för HTML och databas hantering. Anton, med huvudansvar för backend delen, är mycket mer bekväm med python än php och har även mer erfarenhet där. Django är även ett mycket väl utvecklat och dokumenterat ramverk så det råder ingen brist på information eller funktionalitet. 