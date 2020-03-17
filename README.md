# BuddyApp
**PHP 2020 BuddyApp**
Soetkin Dieltiens, projectmanager
Davy Ceuppens, lead frontend
Fre Hermans, lead frontend
Medina Dadurgova, lead backend


## OOP Richtlijnen — [crash course](https://courses.goodbytes.be/course/5e6e800577759b00123beb10/0)
1. Welke functies zijn broodnodig in de app? users, posts, comments, locations...
        -> elke functie krijgt zijn eigen class

2. Let op volgende richtlijnen bij het creëeren van een nieuwe class:
    - gebruik hoofdletter! (niet "user.php" maar "User.php")
    - enkelvoud! (niet "Users.php" maar "User.php")

3. Zet variabelen private in classes en gebruik getters & setters. In geval van [overervende classes](https://courses.goodbytes.be/course/5e6e800577759b00123beb10/7), zet variabelen op protected.

4. Gebruik exceptions & try/catch om errors op te vangen en weer te geven.

5. Hergebruik database connectie via het [singleton patroon](https://courses.goodbytes.be/course/5e6e800577759b00123beb10/5)

6. Voor variabelen en functienamen opteer voor camel case
        -> e.g; buyTicket ipv buyticket of buy_ticket

7. Indien [interfaces](https://courses.goodbytes.be/course/5e6e800577759b00123beb10/8) bestaan, implementeer deze in alle classes.

**SCHRIJF ALTIJD VOLDOENDE EN DUIDELIJKE COMMENTAAR IN JE CODE**