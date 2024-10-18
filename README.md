## Professional Services Solutions

## Laravel Junior Developer Test

### Project Description:
This project is a simple CRUD application, focusing on the Company model. It consists of the
following pages:
* Welcome page displayed to guests
* Log In & Register pages
* User Profile update page
* Index, create & edit pages for Companies

A user can interact only with Companies that belong to him. 

Through the use of soft deletes, the user is also able to view his Companies that have been deleted and restore or permanently remove them.

### Setup Instrctions
The project was developed locally using Laravel Sail. Assuming that the reviewer has Docker installed,
the setup process requires the following steps:

* Clone the repository.
* Install dependencies via composer.
* Run ```./vendor/bin/sail up``` to get Sail going.
* ```./vendor/bin/sail mysql``` to access the MySQL container if needed (e.g. to create the db).
* ```./vendor/bin/sail up artisan migrate``` to run the migrations.
* ```./vendor/bin/sail up artisan db:seed``` to seed the database.
* ```npm install``` to install the node dependencies.
* ```npm run build``` to create a production build.

The project should now ready to access in ```http://localhost```.

### Assumptions
* An extra model named Sector was created, with its only field being ```name```, mostly for filtering purposes. This model has a
one-to-many relationship with Company, meaning that a Sector can have many Companies. This model doesn't have any views and it is just
being populated via the ```SectorSeeder```.


* Except from the required fields (name, address, website, email), the Company model has also the following fields:
    * ```number_of_employees```: a simple unsigned integer field, that exists only for extra filtering options.
    * ```sector_id```: to support the one-to-many relationship between Sectors and Companies.
    * ```user_id```: to support the one-to-many relationship between Users and Companies.


* In the Companies index page, the user can filter the companies that he owns via the following filters:
    * ```number_of_employees```: expressed as ranges (1-10, 11-50, ..., 1001+)
    * ```sector_id```: the user is able to filter the companies based on multiple sectors (multiple select)
    * There is also a search field, that searches companies via their name
  
* The index page works via ajax requests.

* I assumed that the ```email``` and ```website``` fields are unique between companies (```name``` field is also unique).

### Testing
Run ```sail artisan test``` to run the available tests. The Unit tests that were added are the following:
* ```CompanyEditTest```: tests whether a user has access only to the edit pages of Companies that he owns 
* ```UserCompanyRelationshipTest```: tests whether the User-Company one-to-many relationship functions as expected
*  ```CompanyServiceTest```: the only available test is responsible for testing if the ```getCompanies``` method 
(called in the Companies index page) only retrieves companies that belong to the current user.  
* ```CompanyIndexTest```: this test only checks whether a logged in User has access to the Companies index route.

<b>Please contact me if you need more information or there is an issue with the setup process.</b>
