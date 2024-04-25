<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project Details
### 1. Technology involved
 > - Laravel 
 > - Stripe ( Payment Gateway)
 > - Laravel Cashier ( Interact with stripe )
 > - Spatie ( multiple roles )
 > - Sanctum ( Api Authentication )
 > - Eloquent ( ORM )

 ### 2. Usage guideline 
> <b>a. To view the available restaurants and filter them based on categories</b>
> > - Api endpoints : http://localhost/api/v1/restaurants
> > - Methods = GET
> >  - parameters :
> >  > - rowsPerPage = Control how many rows per page for restaurants to display
> >  > - isFilterCategories = Decide if want to filter the restaurants by categories ( e.g. Western, Asian, Dessert)
> >  > - categories = value of the categories to filter, must have if isFilterCategories is true

> <b>b. Access to detailed restaurants information and menus</b>
> > - Api endpoints : http://localhost/api/v1/restaurants/menus/{id}
> > - Methods = GET
> > - parameters : 
> > > - rowsPerPage = Control how many rows per page for menus to display

> <b>c. Capabilities to place orders
> > - Api endpoints : http://localhost/api/v1/restaurants/orders/{id}
> > - Methods : POST
> > - parameters : 
> > > - type_of_deliveries : value can be either pickup or deliveries
> > > - status : By default it will be pending.
> > - remarks : This will cretea a new order in system, can change the value of parameter for type_of_deliveries to decide either the order want delieries or pickup

> <b>d. Make a payment for the invoice using stripe
> > - Api endpoints : http://localhost/api/v1/invoices/pay/{id}
> > - Methods : POST
> > - remarks : The id is the invoices id, the users that want to pay for this invoice will need to have payment method in stripe for payment to be succesful, or else it will have status incomplete


> <b>e. Manage incoming orders for their respective restaurants



Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.


## Project detais