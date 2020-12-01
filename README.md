# CS-3265-Project
## How to View Website
The website consists of five pages that are a .php type. Therefore, you must have php capabilities running on your computer to view and interact with the website.
### Set Up Database
To start, please download the dataset from this website: https://www.kaggle.com/sobhanmoosavi/us-accidents to your computer. Upon downloading the zip, extract it and pull the CSV file. **If you have a specific directory that data needs to be put into to run `LOAD DATA LOCAL INFILE` statements correctly, please move the CSV file to that directory and copy the path for the file**.

From there, start your SQL server (whether that is MAMP or Homebrew services) and open the loadData.sql and decomposition.sql files in mySQL Workbench in that connection. Replace the path on line 64 of loadData.sql with the path to the CSV file and run it to create the database. Once the database is created, run the decomposition.sql file to create the appropriate views, tables, and procedures for the database. Now, you can run the website.

### Set Up Website
To run this website, you must set up the credentials in the conn.php file. If you are running your SQL Server using a MAMP/WAMP service, you should be able to find the information about the connection to the database from the website. If you are using another service to run your SQL Server, you should be able to retrieve that information from the connection tab in mySQL Workbench and add those credentials to the conn.php file.

**NOTE:** There are two sections in the conn.php file where the database is being loaded using port 3306 and port 8889. Please update and change as you see fit.

**NOTE:** Depending on if you have a Mac or Windows machine, there may be different services you need to use in order to get your machine to properly display PHP files on your web service. Here are some resources you can use to ensure that your PHP file runs correctly:
* For Mac Users: https://jasonmccreary.me/articles/install-apache-php-mysql-mac-os-x-catalina/
* For Windows Users: https://www.sitepoint.com/how-to-install-php-on-windows/


### Interacting with the Website
The website consists of six different pages. The homepage, `index.html`, shows a description of the dataset, database, and the DML Usage in the database. Each of the subsequent pages interacts with the database in a different way.
###### Search Accidents
The purpose of this page is to view location, description, and time information about an accident based on the ID or zip code. To test the functionality of this page, you can enter any ID in the format of A-#, where, given that there are over 3.5 million records in the database, the # can be any number between 1 and at least 1.5 million (i.e. A-1, A-4000, A-65535). You can also test the zip code functionality by entering any zip code in the United States. We know that there are many records to show for zip code 30013 and none to show for zip code 37235. A list of accidents will populate on the page when it has finished pulling the information from the database.

###### View Accident Area by State
The purpose of this page is to view the number of accidents per state with specific road elements and different severity levels. The options for the states you can select will only be those states that are in the database. Therefore, all of the states in there will produce a result. To test the functionality, select a random state and allow for the information to load. A graph and multiple graphics should populate on the page when it is done.

###### View Accident Weather Conditions
The purpose of this page is the display the weather conditions for a specific accident based on its ID. To test the functionality of this page, you can enter any ID in the format of A-#, where, given that there are over 3.5 million records in the database, the # can be any number between 1 and at least 1.5 million (i.e. A-1, A-4000, A-65535). A graphic showing the weather conditions will display on the page when all the information has been pulled according to the ID.

###### Report an Accident
The purpose of this page is to add a new accident to the database. The form must have an end time that is equal to or past the start time and a unique ID to successfully enter it in the database. To test the functionality, you should attempt to report an accident with an existing ID and when the end time is before the start time (as well as variations of each. We recommend that, to successfully add data to the database, you should use an ID that is a different format from A-#. When you have successfully entered one, remember the ID you used as this will help with the Delete an Accident page.

###### Delete an Accident
The purpose of this page is to delete a recently added accident to the database, and not a accident that was loaded from the original database. To test this page, you must first successfully add an accident to the database using the Report an Accident page. To test the functionality, you can attempt to delete any accident with the format A-#, which will throw an error and not delete that recorded accident. To successfully delete an accident, enter the ID of the accident you recently added on the Report an Accident page.
