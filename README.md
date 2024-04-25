<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



## Project Details ( Todak Digitech Restaurant Assestment Project)
### 1. Technology involved
 > - Laravel 
 > - Stripe ( Payment Gateway)
 > - Laravel Cashier ( Interact with stripe )
 > - Spatie ( multiple roles )
 > - Sanctum ( Api Authentication )
 > - Eloquent ( ORM )

 > ### 1.2. Installation
 > - Git clone the project
 > - Replace the .env file 
 > - Create a new database based on the table name in env file
 > - run php artisan optimize:clear to clear the cache
 > - run php artisan migrate
 > - run php artisan seed:dummy
> > - This is customize command to initial seed the data


 ### 2. Usage guideline 
> <b>a. To view the available restaurants and filter them based on categories</b>
> > - Api endpoints : http://localhost/api/v1/restaurants
> > - Methods = GET
> >  - Parameters :
> >  > - rowsPerPage = Control how many rows per page for restaurants to display
> >  > - isFilterCategories = Decide if want to filter the restaurants by categories ( e.g. Western, Asian, Dessert)
> >  > - categories = value of the categories to filter, must have if isFilterCategories is true

> <b>b. Access to detailed restaurants information and menus</b>
> > - Api endpoints : http://localhost/api/v1/restaurants/menus/{id}
> > - Methods = GET
> > - Parameters : 
> > > - rowsPerPage = Control how many rows per page for menus to display

> <b>c. Capabilities to place orders
> > - Api endpoints : http://localhost/api/v1/restaurants/orders/{id}
> > - Methods : POST
> > - Parameters : 
> > > - type_of_deliveries : value can be either pickup or deliveries
> > > - status : By default it will be pending.
> > - Remarks : This will cretea a new order in system, can change the value of parameter for type_of_deliveries to decide either the order want delieries or pickup

> <b>d. Make a payment for the invoice using stripe
> > - Api endpoints : http://localhost/api/v1/invoices/pay/{id}
> > - Methods : POST
> > - Remark : The id is the invoices id, the users that want to pay for this invoice will need to have payment method in stripe for payment to be succesful, or else it will have status incomplete


> <b>e. Manage incoming orders for their respective restaurants
> > - Api endpoints : http://localhost/api/v1/restaurants/order/:id
> > - Methods : GET
> > - Parameters : 
> > > - rows_per_page
> > > - manager_id = To get the orders based on the manager id
> > > - isFilterOrderStatus
> > > - orderStatus
> > Remark : Have logic error where there supposedly only filtered by manager_id, required ammendment

> <b>f. Ability to reject customer order
> > - Api endpoints : http://localhost/restaurants/orders/{id}
> > - Methods : PUT 
> > - Parameters :
> > > - type_of_deliveries
> > > - status
> > > - Remark : Only accessable to manager user only


> <b>g.  Approval process for newly registered restaurants.
> > - Api endpoints : http://localhost/restaurants
> > - Methods : POST
> > - Parameters : 
> > > - name
> > > - address 
> > > - categories
> > - Remark : By default, the operation status will be inactive and approval status will be pending , to approve or ban or disabled the restaurants can use the below endpoints

> <b>h. Authority to ban or disable restaurants if required
> > - Api endpoints : http://localhost/restaurants
> > - Methods : PUT 
> > - Parameter :
> > > - name
> > > - address 



 ### 3. System design

> <b>This system using system design such as </b>

> - Dependency injection 
> > - Stripe service & PaymentGateway Interface : to provide independency and decoupling in which we can change and afford to have more payment gateway easily in the future without breaking the system

> - Trait 
> > - The purpose it to provide re-usable code 
> > - Error Traits : to process the validation error message 

> - Versioning
> > - For api endpoints, we are using versioning which is useful for mobile development support. This is due to mobile have many version need to be supported unlike web whcih will alway have latest version

> - ERD Diagram
![GitHub Logo](https://github.com/eirfan/todak-digitech-restaurant/blob/main/public/todak-digitech-restaurent%20ERD.png?raw=true)


### Importants notes

> - 1. For stripe, due to the limitation of the api and testing account, we cannot set the payment method ( card ) for client due to that stripe change the menthod of assigning payment methd using front-end, meaning that it is not possible to assign dummy payment method in the backend level without fron-end.
> > - Therefore to insert the card details, need to login to stripe and add manually payment method.

> - 2. Accounts for testing purposes
> > - email : client@todak.my
> > - password : todak88!








